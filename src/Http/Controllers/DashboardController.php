<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Narsil;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DashboardController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return Narsil::render('narsil/cms::index');
    }

    #endregion
}
