<?php

namespace Narsil\Http\Controllers\Policies\Permissions;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Contracts\FormRequests\PermissionFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Policies\Permission;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PermissionUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param PermissionFormRequest $request
     * @param Permission $permission
     *
     * @return RedirectResponse
     */
    public function __invoke(PermissionFormRequest $request, Permission $permission): RedirectResponse
    {
        $attributes = $request->validated();

        $permission->update($attributes);

        return $this
            ->redirect(route('permissions.index'))
            ->with('success', ModelService::getSuccessMessage(Permission::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
