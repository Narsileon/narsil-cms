<?php

namespace App\Http\Controllers\Resources;

#region USE

use App\Contracts\FormRequests\Resources\UserFormRequest;
use App\Contracts\Forms\Resources\UserForm;
use App\Enums\Forms\MethodEnum;
use App\Http\Controllers\AbstractModelController;
use App\Http\Resources\DataTableCollection;
use App\Models\User;
use App\Narsil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserController extends AbstractModelController
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
        $dataTable = new DataTableCollection(User::query(), User::TABLE);

        return Narsil::render('resources/index', [
            'dataTable' => $dataTable,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request): JsonResponse|Response
    {
        $form = $this->form->get(
            action: route('users.store'),
            method: MethodEnum::POST,
            submit: trans('ui.create'),
        );

        return Narsil::render('resources/form', [
            'form' => $form,
            'title' => trans('ui.user'),
        ]);
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

        return $this->redirectOnStored(User::TABLE);
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
            action: route('users.update', $user->{User::ID}),
            method: MethodEnum::PATCH,
            submit: trans('ui.update'),
        );

        return Narsil::render('resources/form', [
            'data' => $user,
            'form' => $form,
            'title' => trans('ui.user'),
        ]);
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

        return $this->redirectOnUpdated(User::TABLE);
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

        return $this->redirectOnDestroyed(User::TABLE);
    }

    #endregion
}
