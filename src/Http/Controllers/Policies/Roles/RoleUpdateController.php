<?php

namespace Narsil\Cms\Http\Controllers\Policies\Roles;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Contracts\Requests\RoleFormRequest;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param RoleFormRequest $request
     * @param Role $role
     *
     * @return RedirectResponse
     */
    public function __invoke(RoleFormRequest $request, Role $role): RedirectResponse
    {
        $attributes = $request->validated();

        $role->update($attributes);

        $role
            ->permissions()
            ->sync(Arr::get($attributes, Role::RELATION_PERMISSIONS, []));

        return $this
            ->redirect(route('roles.index'))
            ->with('success', ModelService::getSuccessMessage(Role::TABLE, ModelEventEnum::UPDATED));
    }

    #endregion
}
