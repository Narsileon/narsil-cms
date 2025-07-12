<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Http\Forms\ForgotPasswordForm;
use App\Services\FormService;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ForgotPasswordController
{
    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $form = (FormService::getForm('forgot-password'))::get(
            action: route('password.email'),
            method: MethodEnum::POST,
            submit: trans('ui.send'),
        );

        $status = session('status');

        $translations = [
            'back'          => trans('ui.back'),
            'password_link' => trans('passwords.link'),
            'title'         => trans('ui.reset_password'),
        ];

        return Inertia::render('fortify/forgot-password', [
            'form'         => $form,
            'status'       => $status,
            'translations' => $translations,
        ]);
    }

    #endregion
}
