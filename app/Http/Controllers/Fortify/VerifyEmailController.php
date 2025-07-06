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

        return Inertia::render('fortify/verify-email', [
            'status' => $status,
        ]);
    }

    #endregion
}
