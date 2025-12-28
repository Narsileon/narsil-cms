<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Narsil\Contracts\Resources\NavigationMenuResource as Contract;
use Narsil\Implementations\AbstractResource;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Sites\SiteUrl;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class NavigationMenuResource extends AbstractResource implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            SitePage::ID => $this->{SitePage::ID},
            SitePage::TITLE => $this->{SitePage::TITLE},

            SitePage::RELATION_CHILDREN => $this->getChildren($request, $this->{SitePage::RELATION_CHILDREN}),

            SiteUrl::URL => $this->{SitePage::RELATION_URLS}?->first()?->{SiteUrl::URL},
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getChildren(Request $request, Collection $children)
    {
        return $children->map(function ($child) use ($request)
        {
            $resource = new static($child);

            return $resource->toArray($request);
        })->toArray();
    }

    #endregion
}
