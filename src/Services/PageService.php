<?php

namespace Narsil\Services;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
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
     * @return Site
     */
    public static function resolveSite(Request $request): ?Site
    {
        $handle = $request->getHost();

        $site = Site::query()
            ->with([
                Site::RELATION_LOCALES,
                Site::RELATION_LOCALES . '.' . HostLocale::RELATION_LANGUAGES
            ])
            ->where(Site::HANDLE, $handle)->firstOrFail();

        if (!$site)
        {
            abort(404);
        }

        return $site;
    }

    /**
     * @param Request $request
     * @param Site $site
     *
     * @return SitePage|null
     */
    public static function resolvePage(Request $request, Site $site): ?SitePage
    {
        $url = $request->fullUrl();

        foreach ($site->{Host::RELATION_LOCALES} as $hostLocale)
        {
            $regex = $hostLocale->{HostLocale::REGEX};

            if (preg_match($regex, $url, $matches))
            {
                return static::getPage(
                    host: Arr::get($matches, 'host'),
                    language: Arr::get($matches, SiteUrl::LANGUAGE),
                    country: Arr::get($matches, SiteUrl::COUNTRY, 'default'),
                    path: Arr::get($matches, SiteUrl::PATH),
                );
            }

            $defaultLocale = $hostLocale->{HostLocale::RELATION_LANGUAGES}?->first();

            if (!$defaultLocale)
            {
                continue;
            }

            $defaultLanguage = $defaultLocale?->{HostLocaleLanguage::LANGUAGE};

            if (!$defaultLanguage)
            {
                continue;
            }

            if (preg_match($regex, $url . '/' . $defaultLanguage, $matches))
            {
                return static::getPage(
                    host: Arr::get($matches, 'host'),
                    language: Arr::get($matches, SiteUrl::LANGUAGE),
                    country: Arr::get($matches, SiteUrl::COUNTRY, 'default'),
                    path: Arr::get($matches, SiteUrl::PATH),
                );
            }
        }

        return null;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param string $host
     * @param string $country
     * @param string $language
     * @param string|null $path
     *
     * @return SitePage|null
     */
    protected static function getPage(string $host, string $country, string $language, ?string $path = null): ?SitePage
    {
        $siteUrl = SiteUrl::query()
            ->with([
                SiteUrl::RELATION_PAGE,
                SiteUrl::RELATION_SITE,
            ])
            ->whereRelation(SiteUrl::RELATION_SITE, Site::HANDLE, '=', $host)
            ->where(SiteUrl::COUNTRY, '=', $country === 'default' ? $country : Str::upper($country))
            ->where(SiteUrl::LANGUAGE, '=', $language)
            ->where(SiteUrl::PATH, '=', $path)
            ->first();

        return $siteUrl?->{SiteUrl::RELATION_PAGE};
    }

    #endregion
}
