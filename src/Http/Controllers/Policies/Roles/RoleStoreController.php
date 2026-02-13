<?php

namespace Narsil\Cms\Http\Controllers\Policies\Roles;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Contracts\Requests\RoleFormRequest;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Models\Policies\Role;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param RoleFormRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(RoleFormRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $role = Role::create($attributes);

        $role
            ->permissions()
            ->sync(Arr::get($attributes, Role::RELATION_PERMISSIONS, []));

        return $this
            ->redirect(route('roles.index'))
            ->with('success', ModelService::getSuccessMessage(Role::TABLE, ModelEventEnum::CREATED));
    }

    #endregion
}
