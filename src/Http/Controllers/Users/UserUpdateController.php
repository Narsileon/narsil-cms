<?php

namespace Narsil\Http\Controllers\Users;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Contracts\FormRequests\UserFormRequest;
use Narsil\Enums\ModelEventEnum;
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
     * @param UserFormRequest $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function __invoke(UserFormRequest $request, User $user): RedirectResponse
    {
        $attributes = $request->validated();

        if (empty(Arr::get($attributes, User::PASSWORD)))
        {
            unset($attributes[User::PASSWORD]);
            unset($attributes[User::ATTRIBUTE_PASSWORD_CONFIRMATION]);
        }

        $user->update($attributes);

        $user
            ->roles()
            ->sync(Arr::get($attributes, User::RELATION_ROLES, []));

        return $this
            ->redirect(route('users.index'))
            ->with('success', ModelService::getSuccessMessage(User::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
