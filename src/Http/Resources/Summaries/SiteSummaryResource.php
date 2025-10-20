<?php

namespace Narsil\Http\Resources\Summaries;

#region USE

use Illuminate\Http\Request;
use Narsil\Http\Resources\AbstractSummaryResource;
use Narsil\Models\Hosts\Host;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteSummaryResource extends AbstractSummaryResource
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            self::HREF => route('sites.edit', $this->{Host::HANDLE}),
            self::NAME => $this->{Host::NAME},
        ];
    }

    #endregion
}
