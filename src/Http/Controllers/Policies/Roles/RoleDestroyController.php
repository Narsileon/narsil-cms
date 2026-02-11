<?php

namespace Narsil\Cms\Http\Controllers\Policies\Roles;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleDestroyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Role $role
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Role $role): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $role);

        $role->delete();

        return $this
            ->redirect(route('roles.index'))
            ->with('success', ModelService::getSuccessMessage(Role::class, ModelEventEnum::DELETED));
    }

    #endregion
}
