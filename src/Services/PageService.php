<?php

namespace Narsil\Services;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Sites\SiteUrl;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class PageService
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return SitePage|null
     */
    public static function resolvePage(Request $request): ?SitePage
    {
        $url = Str::lower($request->url());

        $siteUrl = SiteUrl::query()
            ->with([
                SiteUrl::RELATION_HOST_LOCALE_LANGUAGE,
            ])
            ->where(SiteUrl::URL, '=', $url)
            ->first();

        if (!$siteUrl)
        {
            abort(404);
        }

        App::setLocale($siteUrl->{SiteUrl::RELATION_HOST_LOCALE_LANGUAGE}->{HostLocaleLanguage::LANGUAGE});

        $siteUrl->loadMissing([
            SiteUrl::RELATION_PAGE . '.' . SitePage::RELATION_SITE . '.' . Site::RELATION_FOOTER,
            SiteUrl::RELATION_PAGE . '.' . SitePage::RELATION_SITE . '.' . Site::RELATION_HEADER,
            SiteUrl::RELATION_PAGE . '.' . SitePage::RELATION_URLS . '.' . SiteUrl::RELATION_HOST_LOCALE_LANGUAGE,
        ]);

        return $siteUrl?->{SiteUrl::RELATION_PAGE};
    }

    #endregion
}
