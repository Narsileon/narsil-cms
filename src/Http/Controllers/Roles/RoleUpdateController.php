<?php

namespace Narsil\Http\Controllers\Roles;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\RoleFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleUpdateController extends AbstractController
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
        $this->authorize(PermissionEnum::UPDATE, $role);

        $data = $request->all();

        $rules = app(RoleFormRequest::class)
            ->rules($role);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $role->update($attributes);

        if ($permissions = Arr::get($attributes, Role::RELATION_PERMISSIONS))
        {
            $role->syncPermissions($permissions);
        }

        return $this
            ->redirect(route('roles.index'))
            ->with('success', trans('narsil::toasts.success.roles.updated'));
    }

    #endregion
}
