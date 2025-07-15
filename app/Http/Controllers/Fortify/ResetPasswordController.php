<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Contracts\Forms\Fortify\ResetPasswordForm;
use App\Enums\Forms\MethodEnum;
use App\Narsil;
use Illuminate\Http\Request;
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
     * @param ResetPasswordForm $form
     *
     * @return void
     */
    public function __construct(ResetPasswordForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var ResetPasswordForm
     */
    protected readonly ResetPasswordForm $form;

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

        return Narsil::render('fortify/form', [
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
