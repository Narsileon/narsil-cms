<?php

namespace Narsil\Http\Controllers;

#region USE

use Narsil\Narsil;
use Illuminate\Http\Request;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HomeController
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
