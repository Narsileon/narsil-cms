<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Http\Forms\RegisterForm;
use App\Services\FormService;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RegisterController
{
    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $form = (FormService::getForm('register'))::get(
            action: route('register'),
            method: MethodEnum::POST,
            submit: trans('ui.register'),
        );

        $translations = [
            'title' => trans('ui.registration'),
        ];

        return Inertia::render('fortify/form', [
            'form'         => $form,
            'translations' => $translations,
        ]);
    }

    #endregion
}
