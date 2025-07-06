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
        $form = FormService::getForm("login", LoginForm::class);

        $status = session('status');

        return Inertia::render('fortify/login', [
            'form' => $form::get(
                action: route('login'),
                method: MethodEnum::POST,
                submit: trans("ui.log_in"),
                title: trans("ui.connection"),
            ),
            'status' => $status,
        ]);
    }

    #endregion
}
