<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
class EntityReplicateController extends RedirectController
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
        $this->authorize(PermissionEnum::CREATE, Entity::class);

        $entity = Entity::query()
            ->firstWhere([
                Entity::ID => $id
            ]);

        EntityService::replicateEntity($entity);

        return back()
            ->with('success', trans('narsil::toasts.success.entities.replicated'));
    }

    #endregion
}
