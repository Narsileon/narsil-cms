<?php

namespace Narsil\Http\Controllers\Roles;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\RoleFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Policies\Role;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Role::class);

        $data = $request->all();

        $rules = app(RoleFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $role = Role::create($attributes);

        $role->permissions()->sync(Arr::get($attributes, Role::RELATION_PERMISSIONS, []));

        return $this
            ->redirect(route('roles.index'))
            ->with('success', ModelService::getSuccessMessage(Role::class, ModelEventEnum::CREATED));
    }

    #endregion
}
