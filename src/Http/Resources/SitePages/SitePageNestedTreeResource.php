<?php

namespace Narsil\Http\Resources\SitePages;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Narsil\Http\Resources\NestedTreeResource;
use Narsil\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageNestedTreeResource extends NestedTreeResource
{
    #region CONSTRUCTOR

    /**
     * @param mixed $resource
     * @param string $site
     *
     * @return void
     */
    public function __construct(mixed $resource, string $site)
    {
        $this->site = $site;

        parent::__construct($resource);
    }

    #endregion

    #region PROPERTIES

    /**
     * The site associated to the request.
     *
     * @var string
     */
    protected readonly string $site;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),

            self::BADGE => $this->getBadge(),
            self::CREATE_URL => $this->getCreateUrl(),
            self::DESTROY_URL => $this->getDestroyUrl(),
            self::EDIT_URL => $this->getEditUrl(),
            self::LABEL => $this->getLabel(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the badge.
     *
     * @return string
     */
    protected function getBadge(): string
    {
        return $this->{SitePage::COUNTRY};
    }

    /**
     * {@inheritDoc}
     */
    protected function getChildren(Request $request, Collection $children)
    {
        return $children->map(function ($child) use ($request)
        {
            $resource = new static($child, $this->site);

            return $resource->toArray($request);
        })->toArray();
    }

    /**
     * Get the create url.
     *
     * @return string
     */
    protected function getCreateUrl(): string
    {
        return route('sites.pages.create', array_merge([
            'site' => $this->site,
        ], [
            SitePage::PARENT_ID => $this->{SitePage::ID},
            SitePage::SITE_ID => $this->{SitePage::SITE_ID},
        ]));
    }

    /**
     * Get the destroy url.
     *
     * @return string
     */
    protected function getDestroyUrl(): string
    {
        return route('sites.pages.destroy', [
            'site' => $this->site,
            'sitePage' => $this->{SitePage::ID},
        ]);
    }

    /**
     * Get the edit url.
     *
     * @return string
     */
    protected function getEditUrl(): string
    {
        return route('sites.pages.edit', [
            'site' => $this->site,
            'sitePage' => $this->{SitePage::ID},
        ]);
    }

    /**
     * Get the label.
     *
     * @return string
     */
    protected function getLabel(): string
    {
        return $this->{SitePage::TITLE} . ' [' . $this->{SitePage::ID} . ']';
    }

    #endregion
}
