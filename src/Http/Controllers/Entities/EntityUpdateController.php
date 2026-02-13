<?php

namespace Narsil\Cms\Http\Controllers\Entities;

#region USE

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Contracts\Requests\EntityFormRequest;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Services\Models\EntityService;
use Narsil\Cms\Traits\IsCollectionController;

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
        $entities = $this->entityClass::query()
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

        $this->authorize(AbilityEnum::UPDATE, $entity);

        $data = $request->all();

        $rules = app(EntityFormRequest::class, [
            'template' => $this->template
        ])->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $entityAttribute = [
            Entity::CREATED_AT => $entity->{Entity::CREATED_AT},
            Entity::CREATED_BY => $entity->{Entity::CREATED_BY},
            Entity::PUBLISHED_FROM => Arr::get($attributes, Entity::PUBLISHED_FROM),
            Entity::PUBLISHED_TO => Arr::get($attributes, Entity::PUBLISHED_TO),
            Entity::SLUG => Arr::get($attributes, Entity::SLUG),
            Entity::UPDATED_AT => Carbon::now(),
            Entity::UPDATED_BY => Auth::id(),
        ];

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

            $replicated->setRelation(Entity::RELATION_TEMPLATE, $this->template);

            EntityService::syncNodes($replicated, $attributes);

            return back();
        }
        else
        {
            $replicated = $this->replicateEntity($entity, array_merge($entityAttribute, [
                Entity::PUBLISHED => false,
            ]));

            $replicated->setRelation(Entity::RELATION_TEMPLATE, $this->template);

            EntityService::syncNodes($replicated, $attributes);

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
                ->with('success', trans('narsil-cms::toasts.success.' . ModelEventEnum::UPDATED->value, [
                    'model' => $this->template->{Template::SINGULAR},
                    'table' => $this->template->{Template::PLURAL},
                ]));
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

        return $replicated;
    }

    #endregion
}
