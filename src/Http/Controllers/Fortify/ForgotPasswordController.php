<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Narsil\Contracts\Forms\Fortify\ForgotPasswordForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Narsil;
use Illuminate\Http\Request;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ForgotPasswordController
{
    #region CONSTRUCTOR

    /**
     * @param ForgotPasswordForm $form
     *
     * @return void
     */
    public function __construct(ForgotPasswordForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var ForgotPasswordForm
     */
    protected readonly ForgotPasswordForm $form;

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
            action: route('password.email'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.send'),
        );

        return Narsil::render('narsil/cms::fortify/form', [
            'form'   => $form,
            'status' => session('status'),
            'title'  => trans('narsil-cms::ui.reset_password'),
        ]);
    }

    #endregion
}
