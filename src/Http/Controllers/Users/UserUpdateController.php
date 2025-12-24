<?php

namespace Narsil\Http\Controllers\Users;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\UserFormRequest;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\User;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserUpdateController extends RedirectController
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
        $this->authorize(PermissionEnum::UPDATE, $user);

        $data = $request->all();

        $rules = app(UserFormRequest::class)
            ->rules($user);

        if (empty(Arr::get($data, User::PASSWORD)))
        {
            unset($data[User::PASSWORD]);
            unset($data[User::ATTRIBUTE_PASSWORD_CONFIRMATION]);
        }

        $attributes = Validator::make($data, $rules)
            ->validated();

        $user->update($attributes);

        if ($roles = Arr::get($attributes, User::RELATION_ROLES))
        {
            $user->syncRoles($roles);
        }

        return $this
            ->redirect(route('users.index'))
            ->with('success', ModelService::getSuccessMessage(User::class, EventEnum::UPDATED));
    }

    #endregion
}
