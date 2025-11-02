<?php

namespace Narsil\Http\Resources\Sites;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Http\Resources\HostPages\HostPageResource;
use Narsil\Models\Hosts\Host;
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
        $tree = new Tree($this->{Host::RELATION_PAGES})->getNestedTree();

        return [
            Host::CREATED_AT => $this->{Host::CREATED_AT},
            Host::HANDLE => $this->{Host::HANDLE},
            Host::ID => $this->{Host::ID},
            Host::NAME => $this->{Host::NAME},
            Host::UPDATED_AT => $this->{Host::UPDATED_AT},

            Host::RELATION_CREATOR => $this->{Host::RELATION_CREATOR},
            Host::RELATION_EDITOR => $this->{Host::RELATION_EDITOR},
            Host::RELATION_PAGES => HostPageResource::collection($tree)->toArray($request),
        ];
    }

    #endregion
}
