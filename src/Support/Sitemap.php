<?php

namespace Narsil\Support;

#region USE

use DOMDocument;
use DOMElement;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Sitemap
{
    #region CONSTRUCTOR

    /**
     * @param HostLocale $hostLocale
     *
     * @return void
     */
    public function __construct(HostLocale $hostLocale)
    {
        $this->document = $this->createDocument();

        $this->hostLocale = $hostLocale;

        $this->pages = $this->getPages();

        $collection = collect($this->pages->get('', []));

        $this->tree = $this->buildFlatTreeRecursively($collection);
    }

    #endregion

    #region PROPERTIES

    /**
     * The associated document.
     *
     * @var DomDocument
     */
    protected readonly DomDocument $document;

    /**
     * The associated host locale.
     *
     * @var Collection<SitePage>
     */
    protected readonly HostLocale $hostLocale;

    /**
     * The associated pages.
     *
     * @var Collection<integer,SitePage>
     */
    protected Collection $pages;

    /**
     * The associated tree.
     *
     * @var Collection<SitePage>
     */
    protected Collection $tree;

    #endregion

    #region PUBLIC METHODS

    /**
     * Generate the sitemap.
     *
     * @return void
     */
    public function generate(): void
    {
        $urlSet = $this->appendUrlSet();

        $country = $this->hostLocale->{HostLocale::COUNTRY};
        $languages = $this->hostLocale->{HostLocale::RELATION_LANGUAGES};
        $urls = $this->hostLocale->{HostLocale::ATTRIBUTE_URLS};

        $defaultLanguage = $languages->first();

        foreach ($this->tree as $page)
        {
            $host = $urls[$defaultLanguage->{HostLocaleLanguage::LANGUAGE}];
            $slug = $page->getTranslationWithoutFallback(SitePage::SLUG, $defaultLanguage->{HostLocaleLanguage::LANGUAGE});

            $url = $this->appendUrl($urlSet);

            $location = "$host/$slug";

            $this->appendLoc($url, $location);

            foreach ($this->hostLocale->{HostLocale::RELATION_LANGUAGES} as $hostLocaleLanguage)
            {
                $language = $hostLocaleLanguage->{HostLocaleLanguage::LANGUAGE};
                $host = $urls[$language];

                $slug = $page->getTranslationWithoutFallback(SitePage::SLUG, $language);
                $hrefLang = $this->getHrefLang($country, $language);

                $xlink = $this->document->createElementNS('http://www.w3.org/1999/xhtml', 'xhtml:link');

                $xlink->setAttribute('rel', 'alternate');
                $xlink->setAttribute('hreflang', $hrefLang);
                $xlink->setAttribute('href', "{$host}/{$slug}");

                $url->appendChild($xlink);
            }

            $this->appendChangeFreq($url, $page->{SitePage::CHANGE_FREQ});
            $this->appendPriority($url, $page->{SitePage::PRIORITY});
        }

        $country = Str::lower($this->hostLocale->{HostLocale::COUNTRY});

        $this->saveDocument("sitemap/{$country}.xml");
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Append a change frequency to the url.
     *
     * @param DOMElement $url
     * @param string $value
     *
     * @return DOMElement
     */
    protected function appendChangeFreq(DOMElement $url, string $value): DOMElement
    {
        $changefreq = $this->document->createElement('changefreq', $value);

        $url->appendChild($changefreq);

        return $changefreq;
    }

    /**
     * Append a loc to the url.
     *
     * @param DOMElement $url
     * @param string $location
     *
     * @return DOMElement
     */
    protected function appendLoc(DOMElement $url, string $location): DOMElement
    {
        $loc = $this->document->createElement('loc', $location);

        $url->appendChild($loc);

        return $loc;
    }

    /**
     * Append a priority to the url.
     *
     * @param DOMElement $url
     * @param string $value
     *
     * @return DOMElement
     */
    protected function appendPriority(DOMElement $url, string $value): DOMElement
    {
        $priority = $this->document->createElement('priority', $value);

        $url->appendChild($priority);

        return $priority;
    }

    /**
     * Append a url to the url set.
     *
     * @param DOMElement $urlSet
     *
     * @return DOMElement
     */
    protected function appendUrl(DOMElement $urlSet): DOMElement
    {
        $url = $this->document->createElement('url');

        $urlSet->appendChild($url);

        return $url;
    }

    /**
     * Append a url set to the document.
     *
     * @return DOMElement
     */
    protected function appendUrlSet(): DOMElement
    {
        $urlSet = $this->document->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'urlset');

        $urlSet->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xhtml', 'http://www.w3.org/1999/xhtml');;

        $this->document->appendChild($urlSet);

        return $urlSet;
    }

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
            else
            {
                foreach ($this->hostLocale->{HostLocale::RELATION_LANGUAGES} as $hostLocaleLanguage)
                {
                    $language = $hostLocaleLanguage->{HostLocaleLanguage::LANGUAGE};

                    $parentSlug = $parent->getTranslationWithFallback(SitePage::SLUG, $language);
                    $slug = $page->getTranslationWithFallback(SitePage::SLUG, $language);

                    $page->setTranslation(SitePage::SLUG, $language, "$parentSlug$slug");
                }
            }

            $tree->push($page);

            $tree = $tree->merge($this->buildFlatTreeRecursively($children, $page));
        });

        return $tree;
    }

    /**
     * Create the document.
     *
     * @return DOMDocument
     */
    protected function createDocument(): DOMDocument
    {
        $document = new DOMDocument('1.0', 'UTF-8');

        $document->formatOutput = true;

        return $document;
    }

    /**
     * Get the href lang.
     *
     * @param string $country
     * @param string $language
     *
     * @return string
     */
    protected function getHrefLang(string $country, string $language): string
    {
        if ($country === 'default')
        {
            $hrefLang = $language;
        }
        else
        {
            $hrefLang = "$language-$country";
        }

        return $hrefLang;
    }

    /**
     * Get the pages grouped by parent id.
     *
     * @return Collection<integer,SitePage>
     */
    protected function getPages(): Collection
    {
        $pages = SitePage::query()
            ->where(SitePage::SITE_ID, '=', $this->hostLocale->{HostLocale::HOST_ID})
            ->get()
            ->groupBy(SitePage::PARENT_ID);

        return $pages;
    }

    /**
     * Save the document.
     *
     * @param string $path
     *
     * @return void
     */
    protected function saveDocument(string $path): void
    {
        $filename = public_path($path);

        if (!file_exists(dirname($filename)))
        {
            mkdir(dirname($filename), 0755, true);
        }

        file_put_contents($filename, $this->document->saveXML());
    }

    #endregion
}
