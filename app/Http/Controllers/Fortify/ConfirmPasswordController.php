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
class ConfirmPasswordController
{
    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $form = (FormService::getForm('confirm-password'))::get(
            action: route('password.confirm'),
            method: MethodEnum::POST,
            submit: trans('ui.confirm'),
        );

        $translations = [
            'title' => trans('ui.confirm_password'),
        ];

        return Inertia::render('fortify/form', [
            'form'         => $form,
            'translations' => $translations,
        ]);
    }

    #endregion
}
