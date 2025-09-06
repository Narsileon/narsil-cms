<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Http\Controllers\AbstractController;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
        return $this->render(
            component: 'narsil/cms::dashboard/index',
            description: trans('narsil::ui.dashboard'),
            title: trans('narsil::ui.dashboard')
        );
    }

    #endregion
}
