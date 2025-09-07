<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Inertia\Response;
use Narsil\Contracts\FormRequests\RoleFormRequest;
use Narsil\Contracts\Forms\RoleForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Requests\DuplicateManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class RoleController extends AbstractController
{
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

        $collection = new DataTableCollection($query, Role::TABLE);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil::tables.roles'),
            description: trans('narsil::tables.roles'),
            props: [
                'collection' => $collection,
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

        $form = app(RoleForm::class);

        $form->action = route('roles.store');
        $form->method = MethodEnum::POST;
        $form->submitLabel = trans('narsil::ui.create');

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
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

        $data = $request->all();

        $rules = app(RoleFormRequest::class)->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $role = Role::create($attributes);

        if ($permissions = Arr::get($attributes, Role::RELATION_PERMISSIONS))
        {
            $role->syncPermissions($permissions);
        }

        return $this
            ->redirect(route('roles.index'))
            ->with('success', trans('narsil::toasts.success.roles.updated'));
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

        $form = app(RoleForm::class);

        $form->action = route('roles.update', $role->{Role::ID});
        $form->data = $role;
        $form->id = $role->{Role::ID};
        $form->method = MethodEnum::PATCH;
        $form->submitLabel = trans('narsil::ui.update');

        $role->setRelation(Role::RELATION_PERMISSIONS, $role->{Role::RELATION_PERMISSIONS}->pluck(PERMISSION::NAME));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
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

        $data = $request->all();

        $rules = app(RoleFormRequest::class)->rules($role);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $role->update($attributes);

        if ($permissions = Arr::get($attributes, Role::RELATION_PERMISSIONS))
        {
            $role->syncPermissions($permissions);
        }

        return $this
            ->redirect(route('roles.index'))
            ->with('success', trans('narsil::toasts.success.roles.updated'));
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
            ->with('success', trans('narsil::toasts.success.roles.deleted'));
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
            ->with('success', trans('narsil::toasts.success.roles.deleted_many'));
    }

    /**
     * @param Request $request
     * @param Role $role
     *
     * @return RedirectResponse
     */
    public function replicate(Request $request, Role $role): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Role::class);

        $this->replicateRole($role);

        return back()
            ->with('success', trans('narsil::toasts.success.roles.replicated'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function replicateMany(DuplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Role::class);

        $ids = $request->validated(DuplicateManyRequest::IDS);

        $roles = Role::query()
            ->with(Role::RELATION_PERMISSIONS)
            ->findMany($ids);

        foreach ($roles as $role)
        {
            $this->replicateRole($role);
        }

        return back()
            ->with('success', trans('narsil::toasts.success.roles.replicated_many'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Role $role
     *
     * @return void
     */
    protected function replicateRole(Role $role): void
    {
        $replicated = $role->replicate();

        $replicated
            ->fill([
                Role::NAME => $role->{Role::NAME} . ' (copy)',
            ])
            ->save();

        $replicated->syncPermissions($role->{Role::RELATION_PERMISSIONS}->pluck(Permission::ID));
    }

    #endregion
}
