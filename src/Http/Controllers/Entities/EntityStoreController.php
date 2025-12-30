<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\EntityDataFormRequest;
use Narsil\Contracts\FormRequests\EntityFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityData;
use Narsil\Models\Structures\Template;
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

        $data = $request->all();

        $entityAttribute = $this->getEntityAttribute($data);
        $entityDataAttribute = $this->getEntityDataAttribute($data);

        $entity = Entity::create([
            Entity::TEMPLATE_ID => $this->template->{Template::ID},
            ...$entityAttribute
        ]);

        EntityData::create([
            EntityData::ENTITY_UUID => $entity->{Entity::UUID},
            ...$entityDataAttribute,
        ]);

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

    #endregion
}
