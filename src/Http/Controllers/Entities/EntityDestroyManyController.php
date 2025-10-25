<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractEntityController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityDestroyManyController extends AbstractEntityController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     * @param integer|string $collection
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request, int|string $collection): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Entity::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Entity::query()
            ->whereIn(Entity::ID, $ids)
            ->forceDelete();

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection,
            ]))
            ->with('success', trans('narsil::toasts.success.entities.deleted_many'));
    }

    #endregion
}
