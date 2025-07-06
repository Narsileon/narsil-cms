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
class ConfirmPasswordController
{
    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return Inertia::render('fortify/confirm-password');
    }

    #endregion
}
