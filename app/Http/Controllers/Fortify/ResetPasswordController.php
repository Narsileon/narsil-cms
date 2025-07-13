<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Interfaces\Forms\Fortify\IResetPasswordForm;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ResetPasswordController
{
    #region CONSTRUCTOR

    /**
     * @param IResetPasswordForm $form
     *
     * @return void
     */
    public function __construct(IResetPasswordForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var IResetPasswordForm
     */
    protected readonly IResetPasswordForm $form;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->form->get(
            action: route('password.update'),
            method: MethodEnum::POST,
            submit: trans('ui.reset'),
        );

        return Inertia::render('fortify/form', [
            'data'  => $this->getData(),
            'form'  => $form,
            'title' => trans('ui.reset_password'),
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,mixed>
     */
    protected function getData(): array
    {
        return [
            'token' => request()->route('token'),
        ];
    }

    #endregion
}
