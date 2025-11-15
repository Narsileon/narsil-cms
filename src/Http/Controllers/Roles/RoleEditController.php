<?php

namespace Narsil\Http\Controllers\Roles;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\RoleForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Role $role
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Role $role): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $role);

        $role->setRelation(Role::RELATION_PERMISSIONS, $role->{Role::RELATION_PERMISSIONS}->pluck(PERMISSION::HANDLE));

        $data = $this->getData($role);
        $form = $this->getForm($role);

        return $this->render('narsil/cms::resources/form', [
            'data' => $data,
            'form' => $form->jsonSerialize(),
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated data.
     *
     * @param Role $role
     *
     * @return array<string,mixed>
     */
    protected function getData(Role $role): array
    {
        $role->loadMissingCreatorAndEditor();

        $role->mergeCasts([
            Role::CREATED_AT => HumanDatetimeCast::class,
            Role::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $role->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil::models.' . Role::class);
    }

    /**
     * Get the associated form.
     *
     * @param Role $role
     *
     * @return RoleForm
     */
    protected function getForm(Role $role): RoleForm
    {
        $form = app(RoleForm::class)
            ->action(route('roles.update', $role->{Role::ID}))
            ->id($role->{Role::ID})
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::models.' . Role::class);
    }

    #endregion
}
