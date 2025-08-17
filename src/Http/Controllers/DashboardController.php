<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Http\Controllers\AbstractController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DashboardController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return $this->render('narsil/cms::dashboard/index');
    }

    #endregion
}
