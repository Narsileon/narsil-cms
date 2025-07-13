<?php

namespace App\Http\Controllers;

#region USE

use App\Narsil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SettingsController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $settings = Config::get('narsil.settings', []);

        return Narsil::render('settings/index', $settings);
    }

    #endregion
}
