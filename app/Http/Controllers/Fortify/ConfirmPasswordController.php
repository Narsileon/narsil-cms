<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Contracts\Forms\Fortify\ConfirmPasswordForm;
use App\Enums\Forms\MethodEnum;
use App\Narsil;
use Illuminate\Http\Request;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfirmPasswordController
{
    #region CONSTRUCTOR

    /**
     * @param ConfirmPasswordForm $form
     *
     * @return void
     */
    public function __construct(ConfirmPasswordForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var ConfirmPasswordForm
     */
    protected readonly ConfirmPasswordForm $form;

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
            action: route('password.confirm'),
            method: MethodEnum::POST,
            submit: trans('ui.confirm'),
        );

        return Narsil::render('fortify/form', [
            'form'  => $form,
            'title' => trans('ui.confirm_password'),
        ]);
    }

    #endregion
}
