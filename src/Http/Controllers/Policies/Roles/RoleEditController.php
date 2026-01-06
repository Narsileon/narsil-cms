<?php

namespace Narsil\Http\Controllers\Policies\Roles;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\RoleForm;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Services\ModelService;

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

        $this->transformPermissions($role);

        $data = $this->getData($role);
        $form = $this->getForm($role);

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
        return ModelService::getModelLabel(Role::class);
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
        $form = app(RoleForm::class, ['model' => $role])
            ->action(route('roles.update', $role->{Role::ID}))
            ->id($role->{Role::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Role::class);
    }

    /**
     * Transform the permissions for the form.
     *
     * @param Role $role
     *
     * @return void
     */
    protected function transformPermissions(Role $role): void
    {
        $permissionIds = $role->{Role::RELATION_PERMISSIONS}
            ->pluck(Permission::ID)
            ->map(function ($id)
            {
                return (string)$id;
            });

        $role->setRelation(Role::RELATION_PERMISSIONS, $permissionIds);
    }

    #endregion
}
