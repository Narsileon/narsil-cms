<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\EntityDataFormRequest;
use Narsil\Contracts\FormRequests\EntityFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityData;
use Narsil\Services\Models\EntityService;
use Narsil\Services\ModelService;
use Narsil\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityUpdateController extends RedirectController
{
    use IsCollectionController;

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param integer|string $collection
     * @param integer $id
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, int|string $collection, int $id): RedirectResponse
    {
        $entities = Entity::query()
            ->where([
                Entity::ID => $id,
            ])
            ->get();

        $entity = $entities->firstWhere(Entity::REVISION, '>', 0);
        $draftEntity = $entities->firstWhere(Entity::REVISION, '=', -1);

        if (!$request->get('_dirty'))
        {
            if ($request->get(Entity::PUBLISHED) && !$entity->{Entity::PUBLISHED})
            {
                $entity->updateQuietly([
                    Entity::PUBLISHED => true,
                ]);

                return $this
                    ->redirect(route('collections.index', [
                        'collection' => $collection
                    ]));
            }
            else if (!$draftEntity)
            {
                return $this
                    ->redirect(route('collections.index', [
                        'collection' => $collection
                    ]));
            }
        }

        $this->authorize(PermissionEnum::UPDATE, $entity);

        $data = $request->all();

        $entityAttribute = $this->getEntityAttribute($data);
        $entityDataAttribute = $this->getEntityDataAttribute($data);

        $entityAttribute = array_merge($entityAttribute, [
            Entity::CREATED_AT => $entity->{Entity::CREATED_AT},
            Entity::CREATED_BY => $entity->{Entity::CREATED_BY},
            Entity::UPDATED_AT => Carbon::now(),
            Entity::UPDATED_BY => Auth::id(),
        ]);

        if ($request->boolean('_autoSave') === true)
        {
            $uuid = null;

            if ($draftEntity)
            {
                $uuid = $draftEntity->{Entity::UUID};

                $draftEntity->forceDeleteQuietly();
            }

            $replicated = $this->replicateEntity($entity, array_merge($entityAttribute, [
                Entity::PUBLISHED => false,
                Entity::REVISION => -1,
                Entity::UUID => $uuid,
            ]));

            EntityData::create([
                EntityData::ENTITY_UUID => $replicated->{Entity::UUID},
                ...$entityDataAttribute,
            ]);

            return back();
        }
        else
        {
            $replicated = $this->replicateEntity($entity, array_merge($entityAttribute, [
                Entity::PUBLISHED => false,
            ]));

            EntityData::create([
                EntityData::ENTITY_UUID => $replicated->{Entity::UUID},
                ...$entityDataAttribute,
            ]);

            $entity->discardChanges();
            $entity->delete();

            if ($draftEntity)
            {
                $draftEntity->forceDeleteQuietly();
            }

            return $this
                ->redirect(route('collections.index', [
                    'collection' => $collection
                ]), $entity)
                ->with('success', ModelService::getSuccessMessage(Entity::class, ModelEventEnum::UPDATED));
        }
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param array $data
     *
     * @return array
     */
    protected function getEntityAttribute(array $data): array
    {
        $rules = app(EntityFormRequest::class)->rules();

        return Validator::make($data, $rules)->validated();
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function getEntityDataAttribute(array $data): array
    {
        $rules = app(EntityDataFormRequest::class, [
            'template' => $this->template,
        ])->rules();

        return Validator::make($data, $rules)->validated();
    }

    /**
     * @param Entity $entity
     * @param array $attributes
     *
     * @return Entity
     */
    protected function replicateEntity(Entity $entity, array $attributes): Entity
    {
        $replicated = $entity->replicate();

        $replicated->fill($attributes);

        $replicated->save();

        $replicated->pruneRevisions(2);

        if ($blocks = request(Entity::RELATION_BLOCKS))
        {
            EntityService::syncBlocks($replicated, $blocks);
        }

        return $replicated;
    }

    #endregion
}
