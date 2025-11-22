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
class SitemapController extends Controller
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $country
     *
     * @return mixed
     */
    public function __invoke(Request $request, string $country): mixed
    {
        $host = $request->getHost();

        $path = public_path("{$host}/sitemap/{$country}.xml");

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
