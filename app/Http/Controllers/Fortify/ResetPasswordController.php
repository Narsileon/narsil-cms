<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Services\FormService;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ResetPasswordController
{
    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $token = request()->route('token');

        $form = (FormService::getForm('reset-password'))::get(
            action: route('password.update'),
            method: MethodEnum::POST,
            submit: trans('ui.reset'),
        );

        $translations = [
            'title' => trans('ui.reset_password'),
        ];

        return Inertia::render('fortify/reset-password', [
            'form'         => $form,
            'token'        => $token,
            'translations' => $translations,
        ]);
    }

    #endregion
}
