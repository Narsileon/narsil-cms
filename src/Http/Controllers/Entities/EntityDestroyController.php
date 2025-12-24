<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Entities\Entity;
use Narsil\Services\ModelService;
use Narsil\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityDestroyController extends RedirectController
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
        $entity = Entity::query()
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->authorize(PermissionEnum::DELETE, $entity);

        $entity->forceDelete();

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection,
            ]))
            ->with('success', ModelService::getSuccessMessage(Entity::class, ModelEventEnum::DELETED));
    }

    #endregion
}
