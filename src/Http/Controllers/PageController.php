<?php

namespace Narsil\Http\Controllers;

#region

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Narsil\Models\Sites\Site;
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
        $host = PageService::resolveSite($request);

        $host->loadMissing([
            Site::RELATION_FOOTER,
            Site::RELATION_HEADER,
        ]);

        $page = PageService::resolvePage($request, $host);

        return Inertia::render('frontend/index', [
            'footer' => $host->{Site::RELATION_FOOTER},
            'header' => $host->{Site::RELATION_HEADER},
            'page' => $page,
        ]);
    }

    #endregion
}
