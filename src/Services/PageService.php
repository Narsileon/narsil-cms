<?php

namespace Narsil\Services;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
     * @return SitePage|null
     */
    public static function resolveURL(Request $request): ?SitePage
    {
        $handle = $request->getHost();

        $host = Host::query()
            ->with([
                Host::RELATION_LOCALES,
                Host::RELATION_LOCALES . '.' . HostLocale::RELATION_LANGUAGES
            ])
            ->where(Host::HANDLE, $handle)->firstOrFail();

        if (!$host)
        {
            abort(404);
        }

        $url = $request->fullUrl();

        foreach ($host->{Host::RELATION_LOCALES} as $hostLocale)
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
     * @param string $path
     *
     * @return SitePage|null
     */
    protected static function getPage(string $host, string $country, string $language, string $path): ?SitePage
    {
        $siteUrl = SiteUrl::query()
            ->with([
                SiteUrl::RELATION_PAGE,
                SiteUrl::RELATION_SITE,
            ])
            ->whereRelation(SiteUrl::RELATION_SITE, Site::HANDLE, '=', $host)
            ->where(SiteUrl::COUNTRY, '=', $country)
            ->where(SiteUrl::LANGUAGE, '=', $language)
            ->where(SiteUrl::PATH, '=', $path)
            ->first();

        return $siteUrl?->{SiteUrl::RELATION_PAGE};
    }

    #endregion
}
