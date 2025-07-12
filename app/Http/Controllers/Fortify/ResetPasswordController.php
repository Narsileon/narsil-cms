<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Interfaces\Forms\IResetPasswordForm;
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
     * @return Response
     */
    public function __invoke(): Response
    {
        $token = request()->route('token');

        $data = [
            'token' => $token,
        ];

        $form = $this->form::get(
            action: route('password.update'),
            method: MethodEnum::POST,
            submit: trans('ui.reset'),
        );

        $translations = [
            'title' => trans('ui.reset_password'),
        ];

        return Inertia::render('fortify/form', [
            'data'         => $data,
            'form'         => $form,
            'translations' => $translations,
        ]);
    }

    #endregion
}
