<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Http\Forms\LoginForm;
use Illuminate\Support\Facades\Config;
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
        $form = Config::get('narsil.forms.login', LoginForm::class);

        $status = session('status');

        return Inertia::render('fortify/login', [
            'form' => $form::get(),
            'status' => $status,
        ]);
    }

    #endregion
}
