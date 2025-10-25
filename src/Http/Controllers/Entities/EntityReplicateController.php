<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractEntityController;
use Narsil\Models\Entities\Entity;
use Narsil\Services\EntityService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityReplicateController extends AbstractEntityController
{
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
