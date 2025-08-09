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
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleController extends AbstractController
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
        $this->authorize(PermissionEnum::VIEW_ANY, Role::class);

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
        $this->authorize(PermissionEnum::CREATE, Role::class);

        $this->form
            ->method(MethodEnum::POST)
            ->url(route('roles.store'));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $this->form->jsonSerialize(),
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Role::class);

        $attributes = $this->getAttributes($this->formRequest->rules());

        Role::create($attributes);

        return $this
            ->redirect(route('roles.index'))
            ->with('success', trans('narsil-cms::toasts.success.roles.updated'));
    }

    /**
     * @param Request $request
     * @param Role $role
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Role $role): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $role);

        $this->form
            ->method(MethodEnum::PATCH)
            ->url(route('roles.update', $role->{Role::ID}));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: array_merge($this->form->jsonSerialize(), [
                'data' => $role,
            ]),
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
        $this->authorize(PermissionEnum::UPDATE, $role);

        $attributes = $this->getAttributes($this->formRequest->rules());

        $role->update($attributes);

        return $this
            ->redirect(route('roles.index'))
            ->with('success', trans('narsil-cms::toasts.success.roles.updated'));
    }

    /**
     * @param Request $request
     * @param Role $role
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $role);

        $role->delete();

        return $this
            ->redirect(route('roles.index'))
            ->with('success', trans('narsil-cms::toasts.success.roles.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Role::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Role::whereIn(Role::ID, $ids)->delete();

        return $this
            ->redirect(route('roles.index'))
            ->with('success', trans('narsil-cms::toasts.success.roles.deleted_many'));
    }

    #endregion
}
