<?php

namespace Narsil\Http\Controllers;

#region

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Narsil\Services\PageService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PageController extends Controller
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function __invoke(Request $request): Response
    {
        $props = PageService::resolveURL(request());

        return Inertia::render('index', $props ?? []);
    }

    #endregion
}
