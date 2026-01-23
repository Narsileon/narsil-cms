<?php

namespace Narsil\Http\Resources\Sites;

#region USE

use Illuminate\Http\Request;
use Narsil\Http\Resources\SummaryResource;
use Narsil\Models\Hosts\Host;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteSummaryResource extends SummaryResource
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            self::HREF => route('sites.edit', $this->{Host::HOSTNAME}),
            self::NAME => $this->{Host::LABEL},
        ];
    }

    #endregion
}
