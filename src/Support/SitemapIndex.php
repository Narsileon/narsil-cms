<?php

namespace Narsil\Support;

#region USE

use DOMDocument;
use DOMElement;
use Illuminate\Support\Str;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitemapIndex
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct(Host $host)
    {
        $this->document = $this->createDocument();

        $this->host = $host;
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

    #endregion

    #region PUBLIC METHODS

    /**
     * Generate the sitemap index.
     *
     * @return void
     */
    public function generate(): void
    {
        $sitemapindex = $this->appendSitemapIndex();

        foreach ($this->host->{Host::RELATION_LOCALES} as $hostLocale)
        {
            new Sitemap($hostLocale)->generate();

            $sitemap = $this->appendSitemap($sitemapindex);

            $location = $this->getLocation($hostLocale);

            $this->appendLoc($sitemap, $location);
        }

        $this->saveDocument('sitemap_index.xml');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Append a loc to the sitemap.
     *
     * @param DOMElement $sitemap
     * @param string $location
     *
     * @return DOMElement
     */
    protected function appendLoc(DOMElement $sitemap, string $location): DOMElement
    {
        $loc = $this->document->createElement('loc', $location);

        $sitemap->appendChild($loc);

        return $loc;
    }

    /**
     * Append a sitemap to the sitemap index.
     *
     * @param DOMElement $sitemapindex
     *
     * @return DOMElement
     */
    protected function appendSitemap(DOMElement $sitemapindex): DOMElement
    {
        $sitemap = $this->document->createElement('sitemap');

        $sitemapindex->appendChild($sitemap);

        return $sitemap;
    }

    /**
     * Append a sitemap index to the document.
     *
     * @return DOMElement
     */
    protected function appendSitemapIndex(): DOMElement
    {
        $sitemapindex = $this->document->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'sitemapindex');

        $this->document->appendChild($sitemapindex);

        return $sitemapindex;
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
     * Get the location of a sitemap.
     *
     * @param HostLocale $hostLocale
     *
     * @return string
     */
    protected function getLocation(HostLocale $hostLocale): string
    {
        $host = $hostLocale->{HostLocale::RELATION_HOST}->{Host::HANDLE};
        $country = Str::lower($hostLocale->{HostLocale::COUNTRY});

        return "https://{$host}/sitemap/{$country}.xml";
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

        file_put_contents($filename, $this->document->saveXML());
    }

    #endregion
}
