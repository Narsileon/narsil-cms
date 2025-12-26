<?php

namespace Narsil\Http\Controllers\Policies\Permissions;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\PermissionForm;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Policies\Permission;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PermissionEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Permission $permission
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Permission $permission): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $permission);

        $data = $this->getData($permission);
        $form = $this->getForm($permission);

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
     * @param Permission $permission
     *
     * @return array<string,mixed>
     */
    protected function getData(Permission $permission): array
    {
        $permission->loadMissingCreatorAndEditor();

        $permission->mergeCasts([
            Permission::CREATED_AT => HumanDatetimeCast::class,
            Permission::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $permission->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Permission::class);
    }

    /**
     * Get the associated form.
     *
     * @param Permission $permission
     *
     * @return PermissionForm
     */
    protected function getForm(Permission $permission): PermissionForm
    {
        $form = app(PermissionForm::class)
            ->action(route('permissions.update', $permission->{Permission::ID}))
            ->id($permission->{Permission::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Permission::class);
    }

    #endregion
}
