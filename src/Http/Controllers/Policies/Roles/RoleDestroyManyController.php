<?php

namespace Narsil\Cms\Http\Controllers\Policies\Roles;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\DestroyManyRequest;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Role::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Role::query()
            ->whereIn(Role::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('roles.index'))
            ->with('success', ModelService::getSuccessMessage(Role::class, ModelEventEnum::DELETED_MANY));
    }

    #endregion
}
