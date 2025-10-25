<?php

namespace Narsil\Http\Controllers\Users;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\UserForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserEditController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param User $user
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, User $user): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $user);

        $user->loadMissing([
            User::RELATION_ROLES,
        ]);

        $user->setRelation(User::RELATION_ROLES, $user->{User::RELATION_ROLES}->pluck(Role::HANDLE));

        $form = app(UserForm::class)
            ->setAction(route('users.update', $user->{User::ID}))
            ->setData($user)
            ->setId($user->{User::ID})
            ->setMethod(MethodEnum::PATCH)
            ->setSubmitLabel(trans('narsil::ui.update'));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion
}
