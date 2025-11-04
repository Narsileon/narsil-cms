<?php

namespace Narsil\Support;

#region USE

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use SimpleXMLElement;

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
    public function __construct()
    {
        $this->collection = HostLocale::query()
            ->with([
                HostLocale::RELATION_HOST,
                HostLocale::RELATION_LANGUAGES,
            ])
            ->orderBy(HostLocale::HOST_ID)
            ->orderBy(HostLocale::POSITION)
            ->get();
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Collection<HostLocale>
     */
    protected readonly Collection $collection;

    #endregion

    #region PUBLIC METHODS

    public function generate(): void
    {
        $this->generateSitemapIndex();
    }

    #endregion

    #region PROTECTED METHODS

    protected function generateSitemapIndex(): void
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex/>');

        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($this->collection as $hostLocale)
        {
            $host = $hostLocale->{HostLocale::RELATION_HOST}->{Host::HANDLE};
            $country = Str::lower($hostLocale->{HostLocale::COUNTRY});

            $sitemap = $xml->addChild('sitemap');

            $sitemap->addChild('loc', url("https://{$host}/sitemap/{$country}.xml"));
        }

        $dom = dom_import_simplexml($xml)->ownerDocument;

        $dom->formatOutput = true;

        $content = $dom->saveXML();

        file_put_contents(public_path('sitemap_index.xml'), $content);
    }

    #endregion
}
