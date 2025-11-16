<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\EntityFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Entities\Entity;
use Narsil\Services\EntityService;
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

        if (!$draftEntity && !$request->get('_dirty'))
        {
            return $this
                ->redirect(route('collections.index', [
                    'collection' => $collection
                ]));
        }

        $this->authorize(PermissionEnum::UPDATE, $entity);

        $template = Entity::getTemplate();

        $data = $request->all();

        $rules = app(EntityFormRequest::class, [
            'template' => $template,
        ])->rules($entity);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $attributes = array_merge($attributes, [
            Entity::CREATED_AT => $entity->{Entity::CREATED_AT},
            Entity::CREATED_BY => $entity->{Entity::CREATED_BY},
            Entity::PUBLISHED => Arr::get($data, Entity::PUBLISHED),
            Entity::PUBLISHED_FROM => Arr::get($data, Entity::PUBLISHED_FROM),
            Entity::PUBLISHED_TO => Arr::get($data, Entity::PUBLISHED_TO),
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

            $this->replicateEntity($entity, array_merge($attributes, [
                Entity::REVISION => -1,
                Entity::UUID => $uuid,
            ]));

            return back();
        }
        else
        {
            $this->replicateEntity($entity, $attributes);

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
                ->with('success', trans('narsil::toasts.success.entities.updated'));
        }
    }

    #endregion

    #region PROTECTED METHODS

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
