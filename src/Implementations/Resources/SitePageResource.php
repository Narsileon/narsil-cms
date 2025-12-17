<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Narsil\Contracts\Resources\EntityResource;
use Narsil\Contracts\Resources\SitePageResource as Contract;
use Narsil\Implementations\AbstractResource;
use Narsil\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageResource extends AbstractResource implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            SitePage::CHANGE_FREQ => $this->{SitePage::CHANGE_FREQ},
            SitePage::CONTENT => $this->getContent(),
            SitePage::ID => $this->{SitePage::ID},
            SitePage::META_DESCRIPTION => $this->{SitePage::META_DESCRIPTION},
            SitePage::OPEN_GRAPH_DESCRIPTION => $this->{SitePage::OPEN_GRAPH_DESCRIPTION},
            SitePage::OPEN_GRAPH_IMAGE => $this->{SitePage::OPEN_GRAPH_IMAGE},
            SitePage::OPEN_GRAPH_TITLE => $this->{SitePage::OPEN_GRAPH_TITLE},
            SitePage::OPEN_GRAPH_TYPE => $this->{SitePage::OPEN_GRAPH_TYPE},
            SitePage::PRIORITY => $this->{SitePage::PRIORITY},
            SitePage::ROBOTS => $this->{SitePage::ROBOTS},
            SitePage::SLUG => $this->{SitePage::SLUG},
            SitePage::TITLE => $this->{SitePage::TITLE},

            SitePage::RELATION_URLS => $this->getUrls(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the content.
     * 
     * @return EntityResource
     */
    protected function getContent(): EntityResource
    {
        $identifier = Arr::first($this->{SitePage::CONTENT});

        $entity = Arr::get($this->{SitePage::ATTRIBUTE_ENTITIES}, $identifier);

        return $entity;
    }

    /**
     * Get the URLs.
     * 
     * @return array
     */
    protected function getUrls(): array
    {
        $urls = [];

        foreach ($this->{SitePage::RELATION_URLS} as $sitePageUrl)
        {
            $urls[] = app(SitePageUrlResource::class, [
                'resource' => $sitePageUrl,
            ]);
        }

        return $urls;
    }

    #endregion
}
