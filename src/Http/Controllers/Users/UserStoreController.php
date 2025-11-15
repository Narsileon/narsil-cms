<?php

namespace Narsil\Http\Controllers\Users;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\UserFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, User::class);

        $data = $request->all();

        $rules = app(UserFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        new User()
            ->forceFill($attributes)
            ->save();

        return $this
            ->redirect(route('users.index'))
            ->with('success', trans('narsil::toasts.success.users.created'));
    }

    #endregion
}
