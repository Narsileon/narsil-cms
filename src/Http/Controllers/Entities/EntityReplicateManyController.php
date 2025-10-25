<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractEntityController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Entities\Entity;
use Narsil\Services\EntityService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityReplicateManyController extends AbstractEntityController
{
    #region CONSTRUCTOR

    /**
     * @param ReplicateManyRequest $request
     * @param integer|string $collection
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request, int|string $collection): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Entity::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $entities = Entity::query()
            ->whereIn(Entity::ID, $ids);

        foreach ($entities as $entity)
        {
            EntityService::replicateEntity($entity);
        }

        return back()
            ->with('success', trans('narsil::toasts.success.entities.replicated_many'));
    }

    #endregion
}
