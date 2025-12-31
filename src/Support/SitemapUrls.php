<?php

namespace Narsil\Support;

#region USE

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Sites\SiteUrl;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitemapUrls
{
    #region CONSTRUCTOR

    /**
     * @param Host $host
     * @param HostLocale $hostLocale
     * @param array $baseUrls
     *
     * @return void
     */
    public function __construct(Host $host, HostLocale $hostLocale, array $baseUrls)
    {
        $this->host = $host;
        $this->hostLocale = $hostLocale;

        $this->baseUrls = $baseUrls;

        $this->pages = $this->getPages();
    }

    #endregion

    #region PROPERTIES

    /**
     * The associated host.
     *
     * @var Host
     */
    protected readonly Host $host;

    /**
     * The associated host locale.
     *
     * @var HostLocale
     */
    protected readonly HostLocale $hostLocale;

    /**
     * The associated pages.
     *
     * @var Collection<integer,SitePage>
     */
    protected Collection $pages;

    /**
     * The associated base urls.
     *
     * @var array
     */
    protected array $baseUrls = [];

    /**
     * The associated site urls.
     *
     * @var array
     */
    protected array $siteUrls = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * Generate the URLs.
     *
     * @return Collection<SitePage>
     */
    public function generate(): Collection
    {
        return DB::transaction(function ()
        {
            SiteUrl::query()
                ->whereIn(SiteUrl::HOST_LOCALE_LANGUAGE_UUID, $this->hostLocale->{HostLocale::RELATION_LANGUAGES}->pluck(HostLocaleLanguage::UUID))
                ->delete();

            $collection = collect($this->pages->get('', []));

            $tree = $this->buildFlatTreeRecursively($collection);

            if (!empty($this->siteUrls))
            {
                SiteUrl::insert($this->siteUrls);
            }

            return $tree;
        });
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Build a flat tree.
     *
     * @param Collection<SitePage> $collection
     * @param SitePage|null $parent
     *
     * @return Collection
     */
    protected function buildFlatTreeRecursively(Collection $collection, ?SitePage $parent = null): Collection
    {
        $tree = collect();

        $collection->each(function ($page) use (&$tree, $parent)
        {
            $children = $this->pages->get($page->{SitePage::ID}, collect());

            foreach ($this->hostLocale->{HostLocale::RELATION_LANGUAGES} as $hostLocaleLanguage)
            {
                $language = $hostLocaleLanguage->{HostLocaleLanguage::LANGUAGE};

                if (!$parent)
                {
                    $url = $this->baseUrls[$language];

                    $page->setTranslation(SitePage::RELATION_URLS, $language, '');
                }
                else
                {
                    $parentSlug = $parent->{SitePage::PARENT_ID} !== null ? $parent->getTranslationWithFallback(SitePage::SLUG, $language) : '';
                    $slug = $page->getTranslationWithFallback(SitePage::SLUG, $language);

                    $path = $parentSlug ? "$parentSlug/$slug" : $slug;
                    $url = $this->baseUrls[$language] . '/' . $path;

                    $page->setTranslation(SitePage::RELATION_URLS, $language, $path);
                }

                $this->siteUrls[] = [
                    SiteUrl::CREATED_AT => now(),
                    SiteUrl::HOST_LOCALE_LANGUAGE_UUID => $hostLocaleLanguage->{HostLocaleLanguage::UUID},
                    SiteUrl::PAGE_ID => $page->{SitePage::ID},
                    SiteUrl::UPDATED_AT => now(),
                    SiteUrl::URL => $url,
                    SiteUrl::UUID => Str::uuid7(),
                ];
            }

            $tree->push($page);

            $tree = $tree->merge($this->buildFlatTreeRecursively($children, $page));
        });

        return $tree;
    }

    /**
     * Get the pages grouped by parent id.
     *
     * @return Collection<integer,SitePage>
     */
    protected function getPages(): Collection
    {
        $currentCountry = Session::get(HostLocale::COUNTRY);

        $country = $this->hostLocale->{HostLocale::COUNTRY};

        Session::put(HostLocale::COUNTRY, $country);

        $pages = SitePage::query()
            ->where(SitePage::SITE_ID, '=', $this->hostLocale->{HostLocale::HOST_ID})
            ->whereIn(SitePage::COUNTRY, [
                $this->hostLocale->{HostLocale::COUNTRY},
                'default',
            ])
            ->get()
            ->groupBy(SitePage::PARENT_ID);

        Session::put(HostLocale::COUNTRY, $currentCountry);

        return $pages;
    }

    #endregion
}
