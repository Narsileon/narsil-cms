<?php

namespace App\Http\Controllers\Fortify;

#region USE

use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class VerifyEmailController
{
    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $status = session('status');

        $translations = [
            'instruction' => trans('verify-email.instruction'),
            'prompt'      => trans('verify-email.prompt'),
            'send_again'  => trans('verify-email.send_again'),
            'sent'        => trans('verify-email.sent'),
            'title'       => trans('ui.email_verify'),
        ];

        return Inertia::render('fortify/verify-email', [
            'status'       => $status,
            'translations' => $translations,
        ]);
    }

    #endregion
}
