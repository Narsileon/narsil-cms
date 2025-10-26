<?php

namespace Narsil\Http\Controllers\Roles;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\RoleForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleEditController extends AbstractController
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

        $role->setRelation(Role::RELATION_PERMISSIONS, $role->{Role::RELATION_PERMISSIONS}->pluck(PERMISSION::NAME));

        $data = $this->getData($role);
        $form = $this->getForm($role)
            ->setData($data);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
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
        $data = $role->toArrayWithTranslations();

        return $data;
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
        $form = app()
            ->make(RoleForm::class)
            ->setAction(route('roles.update', $role->{Role::ID}))
            ->setId($role->{Role::ID})
            ->setMethod(MethodEnum::PATCH)
            ->setSubmitLabel(trans('narsil::ui.update'));

        return $form;
    }

    #endregion
}
