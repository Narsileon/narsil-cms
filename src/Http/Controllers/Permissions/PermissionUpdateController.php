<?php

namespace Narsil\Http\Controllers\Permissions;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\PermissionFormRequest;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
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
     * @param Request $request
     * @param Permission $permission
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Permission $permission): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $permission);

        $data = $request->all();

        $rules = app(PermissionFormRequest::class)
            ->rules($permission);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $permission->update($attributes);

        return $this
            ->redirect(route('permissions.index'))
            ->with('success', ModelService::getSuccessMessage(Permission::class, EventEnum::UPDATED));
    }

    #endregion
}
