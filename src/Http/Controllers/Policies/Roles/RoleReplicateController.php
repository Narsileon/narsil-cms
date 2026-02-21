<?php

namespace Narsil\Cms\Http\Controllers\Policies\Roles;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Models\Policies\Role;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Services\RoleService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleReplicateController extends RedirectController
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
        $this->authorize(AbilityEnum::CREATE, Role::class);

        RoleService::replicate($role);

        return back()
            ->with('success', ModelService::getSuccessMessage(Role::TABLE, ModelEventEnum::REPLICATED));
    }

    #endregion
}
