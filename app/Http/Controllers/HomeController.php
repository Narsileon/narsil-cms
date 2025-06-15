<?php

namespace App\Http\Controllers;

#region USE

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

#endregion

final class HomeController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Index');
    }

    #endregion
}
