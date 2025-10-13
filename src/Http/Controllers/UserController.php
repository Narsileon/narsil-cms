<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Inertia\Response;
use Narsil\Contracts\FormRequests\UserFormRequest;
use Narsil\Contracts\Forms\UserForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Collections\DataTableCollection;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class UserController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, User::class);

        $query = User::query();

        $collection = new DataTableCollection($query, User::TABLE);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil::tables.users'),
            description: trans('narsil::tables.users'),
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
        $this->authorize(PermissionEnum::CREATE, User::class);

        $form = app(UserForm::class)
            ->action(route('users.store'))
            ->method(MethodEnum::POST)
            ->submitLabel(trans('narsil::ui.save'));

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
        $this->authorize(PermissionEnum::CREATE, User::class);

        $data = $request->all();

        $rules = app(UserFormRequest::class)->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        User::create($attributes);

        return $this
            ->redirect(route('users.index'))
            ->with('success', trans('narsil::toasts.success.users.created'));
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, User $user): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $user);

        $user->loadMissing([
            User::RELATION_ROLES,
        ]);

        $user->setRelation(User::RELATION_ROLES, $user->{User::RELATION_ROLES}->pluck(Role::HANDLE));

        $form = app(UserForm::class)
            ->action(route('users.update', $user->{User::ID}))
            ->data($user)
            ->id($user->{User::ID})
            ->method(MethodEnum::PATCH)
            ->submitLabel(trans('narsil::ui.update'));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $user);

        $data = $request->all();

        $rules = app(UserFormRequest::class)->rules($user);

        if (empty(Arr::get($data, User::PASSWORD)))
        {
            unset($data[User::PASSWORD]);
            unset($data[User::ATTRIBUTE_PASSWORD_CONFIRMATION]);
        }

        $attributes = Validator::make($data, $rules)
            ->validated();

        $user->update($attributes);

        return $this
            ->redirect(route('users.index'))
            ->with('success', trans('narsil::toasts.success.users.updated'));
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $user);

        $user->delete();

        return $this
            ->redirect(route('users.index'))
            ->with('success', trans('narsil::toasts.success.users.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, User::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        User::whereIn(User::ID, $ids)->delete();

        return $this
            ->redirect(route('users.index'))
            ->with('success', trans('narsil::toasts.success.users.deleted_many'));
    }

    #endregion
}
