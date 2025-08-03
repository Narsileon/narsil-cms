<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\FormRequests\UserFormRequest;
use Narsil\Contracts\Forms\UserForm;
use Narsil\Contracts\Tables\UserTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @param UserForm $form
     * @param UserFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(UserForm $form, UserFormRequest $formRequest)
    {
        $this->form = $form;
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var UserForm
     */
    protected readonly UserForm $form;
    /**
     * @var UserFormRequest
     */
    protected readonly UserFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $query = User::query();

        $dataTable = new DataTableCollection($query, app(UserTable::class));

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil-cms::ui.users'),
            description: trans('narsil-cms::ui.users'),
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
            url: route('users.store'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.create'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.user'),
            description: trans('narsil-cms::ui.user'),
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

        User::create($attributes);

        return $this
            ->redirect(route('users.index'))
            ->with('success', trans('narsil-cms::toasts.success.users.created'));
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, User $user): JsonResponse|Response
    {
        $form = $this->form->get(
            url: route('users.update', $user->{User::ID}),
            method: MethodEnum::PATCH,
            submit: trans('narsil-cms::ui.update'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.user'),
            description: trans('narsil-cms::ui.user'),
            props: [
                'data' => $user,
                'form' => $form,
            ]
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
        $attributes = $this->getAttributes($this->formRequest->rules());

        $user->update($attributes);

        return $this
            ->redirect(route('users.index'))
            ->with('success', trans('narsil-cms::toasts.success.users.updated'));
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        return $this
            ->redirect(route('users.index'))
            ->with('success', trans('narsil-cms::toasts.success.users.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $ids = $request->validated(DestroyManyRequest::IDS);

        User::whereIn(User::ID, $ids)->delete();

        return $this
            ->redirect(route('users.index'))
            ->with('success', trans('narsil-cms::toasts.success.users.deleted_many'));
    }

    #endregion
}
