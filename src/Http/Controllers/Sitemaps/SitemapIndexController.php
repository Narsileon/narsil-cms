<?php

namespace Narsil\Cms\Http\Controllers\Sitemaps;

#region USE

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

#endregion

class SitemapIndexController extends Controller
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $host = $request->getHost();

        $path = "{$host}/sitemap_index.xml";

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
