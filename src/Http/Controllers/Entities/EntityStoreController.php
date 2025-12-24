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
use Narsil\Services\Models\EntityService;
use Narsil\Services\ModelService;
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
        $this->authorize(PermissionEnum::CREATE, Entity::class);

        $template = Entity::getTemplate();

        $data = $request->all();

        $rules = app(EntityFormRequest::class, [
            'template' => $template,
        ])->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $attributes = array_merge($attributes, [
            Entity::PUBLISHED_FROM => Arr::get($data, Entity::PUBLISHED_FROM),
            Entity::PUBLISHED_TO => Arr::get($data, Entity::PUBLISHED_TO),
        ]);

        $entity = Entity::create($attributes);

        if ($blocks = Arr::get($data, Entity::RELATION_BLOCKS))
        {
            EntityService::syncBlocks($entity, $blocks);
        }

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection,
            ]), $entity)
            ->with('success', ModelService::getSuccessMessage(Entity::class, ModelEventEnum::CREATED));
    }

    #endregion
}
