<?php

namespace Narsil\Support;

#region USE

use DOMDocument;
use DOMElement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Narsil\Models\Hosts\Host;
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
     * @param Host $host
     * @param HostLocale $hostLocale
     *
     * @return void
     */
    public function __construct(Host $host, HostLocale $hostLocale)
    {
        $this->document = $this->createDocument();

        $this->host = $host;
        $this->hostLocale = $hostLocale;

        $this->baseUrls = $this->getBaseUrls();

        $this->tree = new SitemapUrls($host, $hostLocale, $this->baseUrls)->generate();
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
     * The associated tree.
     *
     * @var Collection<SitePage>
     */
    protected Collection $tree;

    /**
     * The associated base urls.
     *
     * @var array
     */
    protected array $baseUrls = [];

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

        $defaultLanguage = $languages->first();

        foreach ($this->tree as $page)
        {
            $slug = $page->getTranslationWithoutFallback(SitePage::RELATION_URLS, $defaultLanguage->{HostLocaleLanguage::LANGUAGE});

            $location = $this->getLocation($defaultLanguage->{HostLocaleLanguage::LANGUAGE}, $slug);

            $url = $this->appendUrl($urlSet);

            $this->appendLoc($url, $location);

            foreach ($this->hostLocale->{HostLocale::RELATION_LANGUAGES} as $hostLocaleLanguage)
            {
                $language = $hostLocaleLanguage->{HostLocaleLanguage::LANGUAGE};

                $slug = $page->getTranslationWithoutFallback(SitePage::RELATION_URLS, $language);

                $location = $this->getLocation($language, $slug);

                $hrefLang = $this->getHrefLang($country, $language);

                $xlink = $this->document->createElementNS('http://www.w3.org/1999/xhtml', 'xhtml:link');

                $xlink->setAttribute('rel', 'alternate');
                $xlink->setAttribute('hreflang', $hrefLang);
                $xlink->setAttribute('href', $location);

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
     * Get the base URLs.
     *
     * @return array<string,string>
     */
    protected function getBaseUrls(): array
    {
        $urls = [];

        $pattern = $this->hostLocale->{HostLocale::PATTERN};

        foreach ($this->hostLocale->{HostLocale::RELATION_LANGUAGES} as $hostLocaleLanguage)
        {
            $language = $hostLocaleLanguage->{HostLocaleLanguage::LANGUAGE};

            $url = $pattern;

            $url = Str::replace('{host}', $this->host->{Host::HANDLE}, $url);
            $url = Str::replace('{country}', $this->hostLocale->{HostLocale::COUNTRY}, $url);
            $url = Str::replace('{language}', $language, $url);

            $urls[$language] = Str::lower($url);
        }

        return $urls;
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
     * Get the location.
     *
     * @param string $language
     *
     * @return string
     */
    protected function getLocation(string $language, string $slug): string
    {
        $baseUrl = $this->baseUrls[$language];

        return $slug ? "{$baseUrl}/{$slug}" : $baseUrl;
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
        $host = $this->host->{Host::HANDLE};

        Storage::disk('public')
            ->put(
                "{$host}/{$path}",
                $this->document->saveXML()
            );
    }

    #endregion
}
