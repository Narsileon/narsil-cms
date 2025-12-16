<?php

namespace Narsil\Http\Controllers\Sitemaps;

#region

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $path = "{$host}/sitemap/{$country}.xml";

        if (!Storage::disk('public')->exists($path))
        {
            abort(404);
        }

        $file = Storage::disk('public')->get($path);

        return response($file, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    #endregion
}
