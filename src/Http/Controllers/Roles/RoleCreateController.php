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
use Narsil\Models\Policies\Role;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleCreateController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, Role::class);

        $form = $this->getForm();

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated form.
     *
     * @return RoleForm
     */
    protected function getForm(): RoleForm
    {
        $form = app(RoleForm::class)
            ->setAction(route('roles.store'))
            ->setMethod(MethodEnum::POST)
            ->setSubmitLabel(trans('narsil::ui.save'));

        return $form;
    }

    #endregion
}
