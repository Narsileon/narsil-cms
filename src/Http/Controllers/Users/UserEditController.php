<?php

namespace Narsil\Http\Controllers\Users;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\UserForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserEditController extends RenderController
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

        $data = $this->getData($user);
        $form = $this->getForm($user);

        return $this->render('narsil/cms::resources/form', [
            'data' => $data,
            'form' => $form,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated data.
     *
     * @param User $user
     *
     * @return array<string,mixed>
     */
    protected function getData(User $user): array
    {
        $user->loadMissingCreatorAndEditor();

        $user->mergeCasts([
            User::CREATED_AT => HumanDatetimeCast::class,
            User::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $user->toArray();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil::models.' . User::class);
    }

    /**
     * Get the associated form.
     *
     * @param User $user
     *
     * @return UserForm
     */
    protected function getForm(User $user): UserForm
    {
        $form = app(UserForm::class)
            ->action(route('users.update', $user->{User::ID}))
            ->id($user->{User::ID})
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::models.' . User::class);
    }

    #endregion
}
