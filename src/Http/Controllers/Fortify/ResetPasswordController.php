<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Narsil\Contracts\Forms\Fortify\ResetPasswordForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Narsil;
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
            submit: trans('narsil-cms::ui.reset'),
        );

        return Narsil::render('narsil/cms::fortify/form', [
            'data'  => $this->getData(),
            'form'  => $form,
            'title' => trans('narsil-cms::ui.reset_password'),
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
