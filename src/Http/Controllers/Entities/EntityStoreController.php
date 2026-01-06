<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\EntityFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Structures\Template;
use Narsil\Services\Models\EntityService;
use Narsil\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityStoreController extends RedirectController
{
    use IsCollectionController;

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param integer|string $collection
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, int|string $collection): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, $this->entityClass);

        $data = $request->all();

        $rules = app(EntityFormRequest::class, [
            'template' => $this->template
        ])->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $entity = $this->entityClass::create([
            Entity::PUBLISHED_FROM => Arr::get($attributes, Entity::PUBLISHED_FROM),
            Entity::PUBLISHED_TO => Arr::get($attributes, Entity::PUBLISHED_TO),
            Entity::SLUG => Arr::get($attributes, Entity::SLUG),
            Entity::TEMPLATE_ID => $this->template->{Template::ID},
        ]);

        $entity->setRelation(Entity::RELATION_TEMPLATE, $this->template);

        EntityService::syncNodes($entity, $attributes);

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection,
            ]), $entity)
            ->with('success', trans('narsil::toasts.success.' . ModelEventEnum::CREATED->value, [
                'model' => $this->template->{Template::SINGULAR},
                'table' => $this->template->{Template::PLURAL},
            ]));
    }

    #endregion
}
