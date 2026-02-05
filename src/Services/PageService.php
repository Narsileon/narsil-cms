<?php

namespace Narsil\Cms\Services;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\SitePageEntity;
use Narsil\Cms\Models\Sites\SiteUrl;

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
     * @return SitePage
     */
    public static function resolvePage(Request $request): SitePage
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
            SiteUrl::RELATION_PAGE . '.' . SitePage::RELATION_ENTITIES . '.' . SitePageEntity::RELATION_TARGET,
            SiteUrl::RELATION_PAGE . '.' . SitePage::RELATION_SITE . '.' . Site::RELATION_FOOTER,
            SiteUrl::RELATION_PAGE . '.' . SitePage::RELATION_SITE . '.' . Site::RELATION_HEADER,
            SiteUrl::RELATION_PAGE . '.' . SitePage::RELATION_URLS . '.' . SiteUrl::RELATION_HOST_LOCALE_LANGUAGE,
            SiteUrl::RELATION_PAGE . '.' . SitePage::RELATION_SITE . '.' . Site::RELATION_FOOTER . '.' . Footer::RELATION_LINKS . '.' . FooterLink::RELATION_SITE_PAGE => function ($query) use ($siteUrl)
            {
                $query->with([
                    SitePage::RELATION_URLS => function ($query) use ($siteUrl)
                    {
                        $query->where(
                            SiteUrl::HOST_LOCALE_LANGUAGE_UUID,
                            $siteUrl->{SiteUrl::RELATION_HOST_LOCALE_LANGUAGE}->{HostLocaleLanguage::UUID}
                        )->with(SiteUrl::RELATION_HOST_LOCALE_LANGUAGE);
                    },
                ]);
            },
            SiteUrl::RELATION_PAGE . '.' . SitePage::RELATION_SITE . '.' . Site::RELATION_PAGES . '.' . SitePage::RELATION_URLS => function ($query) use ($siteUrl)
            {
                $query
                    ->where(
                        SiteUrl::HOST_LOCALE_LANGUAGE_UUID,
                        $siteUrl->{SiteUrl::RELATION_HOST_LOCALE_LANGUAGE}->{HostLocaleLanguage::UUID}
                    )
                    ->with(SiteUrl::RELATION_HOST_LOCALE_LANGUAGE);
            },
        ]);

        return $siteUrl->{SiteUrl::RELATION_PAGE};
    }

    #endregion
}
