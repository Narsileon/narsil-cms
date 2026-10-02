<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Resources\Frontend;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\SiteUrl;

#endregion

class NavigationResource extends JsonResource
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            SitePage::ID => $this->resource->{SitePage::ID},
            SitePage::TITLE => $this->resource->{SitePage::TITLE},
            SiteUrl::URL => $this->resource->{SitePage::RELATION_URLS}->first()?->{SiteUrl::URL},

            SitePage::RELATION_CHILDREN => $this->getChildren($request),
        ];
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param Request $request
     *
     * @return array
     */
    private function getChildren(Request $request): array
    {
        return Collection::make($this->resource->{SitePage::RELATION_CHILDREN})->map(function (SitePage $child) use ($request): array
        {
            return new static($child)
                ->toArray($request);
        })->all();
    }

    #endregion
}
