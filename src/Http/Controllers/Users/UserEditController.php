<?php

namespace Narsil\Cms\Http\Controllers\Users;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Models\Policies\Role;
use Narsil\Cms\Casts\HumanDatetimeCast;
use Narsil\Cms\Contracts\Forms\UserForm;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\User;
use Narsil\Cms\Services\ModelService;

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
        $this->authorize(AbilityEnum::UPDATE, $user);

        $user->loadMissing([
            User::RELATION_ROLES,
        ]);

        $this->transformRoles($user);

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
        return ModelService::getModelLabel(User::TABLE);
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
        $form = app(UserForm::class, ['model' => $user])
            ->action(route('users.update', $user->{User::ID}))
            ->id($user->{User::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil-cms::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(User::TABLE);
    }

    /**
     * Transform the roles for the form.
     *
     * @param User $user
     *
     * @return void
     */
    protected function transformRoles(User $user): void
    {
        $roleIds = $user->{User::RELATION_ROLES}
            ->pluck(Role::ID)
            ->map(function ($id)
            {
                return (string)$id;
            });

        $user->setRelation(User::RELATION_ROLES, $roleIds);
    }

    #endregion
}
