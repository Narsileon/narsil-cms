<?php

namespace Narsil\Http\Resources\Summaries;

#region USE

use Illuminate\Http\Request;
use Narsil\Models\Hosts\Host;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteResource extends AbstractSummaryResource
{
    #region CONSTRUCTOR

    /**
     * @param Host $resource
     *
     * @return void
     */
    public function __construct(Host $resource)
    {
        parent::__construct($resource);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            Host::HANDLE => $this->{Host::HANDLE},
            Host::ID => $this->{Host::ID},
            Host::NAME => $this->{Host::NAME},
        ];
    }

    #endregion
}
