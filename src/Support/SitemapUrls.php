<?php

namespace Narsil\Support;

#region USE

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
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
     * @param HostLocale $hostLocale
     *
     * @return void
     */
    public function __construct(HostLocale $hostLocale)
    {
        $this->hostLocale = $hostLocale;

        $this->pages = $this->getPages();
    }

    #endregion

    #region PROPERTIES

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
     * The associated urls.
     *
     * @var array
     */
    protected array $urls = [];

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
                ->where(SiteUrl::SITE_ID, '=', $this->hostLocale->{HostLocale::HOST_ID})
                ->where(SiteUrl::COUNTRY, '=', $this->hostLocale->{HostLocale::COUNTRY})
                ->delete();

            $collection = collect($this->pages->get('', []));

            $tree = $this->buildFlatTreeRecursively($collection);

            if (!empty($this->urls))
            {
                SiteUrl::insert($this->urls);
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

            if (!$parent)
            {
                $page->{SitePage::SLUG} = null;
            }

            foreach ($this->hostLocale->{HostLocale::RELATION_LANGUAGES} as $hostLocaleLanguage)
            {
                $language = $hostLocaleLanguage->{HostLocaleLanguage::LANGUAGE};

                if (!$parent)
                {
                    $path = null;
                }
                else
                {
                    $parentSlug = $parent->getTranslationWithFallback(SitePage::SLUG, $language);
                    $slug = $page->getTranslationWithFallback(SitePage::SLUG, $language);

                    $path = $parentSlug ? "$parentSlug/$slug" : $slug;

                    $page->setTranslation(SitePage::SLUG, $language, $path);
                }

                $this->urls[] = [
                    SiteUrl::COUNTRY => $this->hostLocale->{HostLocale::COUNTRY},
                    SiteUrl::CREATED_AT => now(),
                    SiteUrl::LANGUAGE => $language,
                    SiteUrl::PAGE_ID => $page->{SitePage::ID},
                    SiteUrl::PATH => $path,
                    SiteUrl::SITE_ID => $page->{SitePage::SITE_ID},
                    SiteUrl::UPDATED_AT => now(),
                    SiteUrl::UUID => Str::uuid(),
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
