<?php

namespace Narsil\Http\Controllers\Roles;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Policies\Role;
use Narsil\Services\RoleService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleReplicateController extends AbstractController
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
        $this->authorize(PermissionEnum::CREATE, Role::class);

        RoleService::replicateRole($role);

        return back()
            ->with('success', trans('narsil::toasts.success.roles.replicated'));
    }

    #endregion
}
