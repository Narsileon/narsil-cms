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
        $title = trans('narsil::ui.dashboard');
        $description = trans('narsil::ui.dashboard');

        return $this->render(
            component: 'narsil/cms::dashboard/index',
            description: $title,
            title: $description,
        );
    }

    #endregion
}
