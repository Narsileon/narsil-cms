<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Contracts\Forms\Fortify\ForgotPasswordForm;
use App\Enums\Forms\MethodEnum;
use App\Narsil;
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
            submit: trans('ui.send'),
        );

        return Narsil::render('fortify/form', [
            'form'   => $form,
            'status' => session('status'),
            'title'  => trans('ui.reset_password'),
        ]);
    }

    #endregion
}
