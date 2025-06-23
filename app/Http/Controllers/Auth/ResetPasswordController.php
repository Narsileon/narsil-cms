<?php

namespace App\Http\Controllers\Auth;

#region USE

use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 *
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

        return Inertia::render('auth/reset-password', [
            'token' => $token,
        ]);
    }

    #endregion
}
