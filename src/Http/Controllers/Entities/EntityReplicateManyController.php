<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Entities\Entity;
use Narsil\Services\Models\EntityService;
use Narsil\Services\ModelService;
use Narsil\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityReplicateManyController extends RedirectController
{
    use IsCollectionController;

    #region PUBLIC METHODS

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
            EntityService::replicate($entity);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Entity::class, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
