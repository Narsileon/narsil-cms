<?php

namespace Narsil\Http\Controllers\Sitemaps;

#region

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitemapIndexController extends Controller
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function __invoke(Request $request): mixed
    {
        $host = $request->getHost();

        $path = public_path("{$host}/sitemap_index.xml");

        if (!file_exists($path))
        {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'application/xml'
        ]);
    }

    #endregion
}
