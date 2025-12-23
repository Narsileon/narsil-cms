<?php

namespace Narsil\Http\Controllers\Roles;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Policies\Role;
use Narsil\Services\Models\RoleService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleReplicateManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Role::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $roles = Role::query()
            ->with(Role::RELATION_PERMISSIONS)
            ->findMany($ids);

        foreach ($roles as $role)
        {
            RoleService::replicateRole($role);
        }

        return back()
            ->with('success', ModelService::getSuccessToast(Role::class, EventEnum::REPLICATED_MANY));
    }

    #endregion
}
