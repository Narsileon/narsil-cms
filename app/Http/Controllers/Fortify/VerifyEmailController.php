<?php

namespace App\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
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
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $status = session('status');

        return Inertia::render('fortify/verify-email', [
            'labels' => $this->getLabels(),
            'status' => $status,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,string>
     */
    protected function getLabels(): array
    {
        return [
            'instruction' => trans('verify-email.instruction'),
            'prompt'      => trans('verify-email.prompt'),
            'send_again'  => trans('verify-email.send_again'),
            'sent'        => trans('verify-email.sent'),
            'title'       => trans('ui.email_verify'),
        ];
    }

    #endregion
}
