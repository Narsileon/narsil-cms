<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\FormRequests\RoleFormRequest;
use Narsil\Contracts\Forms\RoleForm;
use Narsil\Contracts\Tables\RoleTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractResourceController;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleController extends AbstractResourceController
{
    #region CONSTRUCTOR

    /**
     * @param RoleForm $form
     * @param RoleFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(RoleForm $form, RoleFormRequest $formRequest)
    {
        $this->form = $form;
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var RoleForm
     */
    protected readonly RoleForm $form;
    /**
     * @var RoleFormRequest
     */
    protected readonly RoleFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $query = Role::query();

        $dataTable = new DataTableCollection($query, app(RoleTable::class));

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil-cms::ui.roles'),
            description: trans('narsil-cms::ui.roles'),
            props: [
                'dataTable' => $dataTable,
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request): JsonResponse|Response
    {
        $form = $this->form->get(
            url: route('roles.store'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.create'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.role'),
            description: trans('narsil-cms::ui.role'),
            props: [
                'form' => $form,
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

        Role::create($attributes);

        return $this->redirectOnStored(Role::TABLE);
    }

    /**
     * @param Request $request
     * @param Role $role
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Role $role): JsonResponse|Response
    {
        $form = $this->form->get(
            url: route('roles.update', $role->{Role::ID}),
            method: MethodEnum::PATCH,
            submit: trans('narsil-cms::ui.update'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.role'),
            description: trans('narsil-cms::ui.role'),
            props: [
                'data' => $role,
                'form' => $form,
            ]
        );
    }

    /**
     * @param Request $request
     * @param Role $role
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

        $role->update($attributes);

        return $this->redirectOnUpdated(Role::TABLE);
    }

    /**
     * @param Request $request
     * @param Role $role
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $role->delete();

        return $this->redirectOnDestroyed(Role::TABLE);
    }

    #endregion
}
