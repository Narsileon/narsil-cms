<?php

namespace Narsil\Http\Resources\Sites;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Http\Resources\SitePages\SitePageResource;
use Narsil\Models\Sites\Site;
use Narsil\Support\Tree;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteResource extends JsonResource
{
    #region PROPERTIES

    /**
     * {@inheritDoc}
     */
    public static $wrap = null;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            Site::CREATED_AT => $this->{Site::CREATED_AT},
            Site::HANDLE => $this->{Site::HANDLE},
            Site::ID => $this->{Site::ID},
            Site::NAME => $this->{Site::NAME},
            Site::UPDATED_AT => $this->{Site::UPDATED_AT},

            Site::RELATION_CREATOR => $this->{Site::RELATION_CREATOR},
            Site::RELATION_EDITOR => $this->{Site::RELATION_EDITOR},
            Site::RELATION_PAGES => $this->getPages($request),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the pages.
     *
     * @param Request $request
     *
     * @return array
     */
    protected function getPages(Request $request): array
    {
        $tree = new Tree($this->{Site::RELATION_PAGES})
            ->getNestedTree();

        $pages = $tree->map(function ($page) use ($request)
        {
            $resource = new SitePageResource($page, $this->{Site::HANDLE});

            return $resource->toArray($request);
        })->toArray();

        return $pages;
    }

    #endregion
}
