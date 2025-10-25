<?php

namespace Narsil\Http\Controllers\Users;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserDestroyController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, User $user): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $user);

        $user->delete();

        return $this
            ->redirect(route('users.index'))
            ->with('success', trans('narsil::toasts.success.users.deleted'));
    }

    #endregion
}
