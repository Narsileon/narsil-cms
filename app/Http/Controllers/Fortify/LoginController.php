<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Http\Forms\LoginForm;
use App\Services\FormService;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LoginController
{
    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $form = (FormService::getForm('login'))::get(
            action: route('login'),
            method: MethodEnum::POST,
            submit: trans('ui.log_in'),
        );

        $status = session('status');

        $translations = [
            'password_link' => trans('passwords.link'),
            'title'         => trans('ui.connection'),
        ];

        return Inertia::render('fortify/form', [
            'form'         => $form,
            'status'       => $status,
            'translations' => $translations
        ]);
    }

    #endregion
}
