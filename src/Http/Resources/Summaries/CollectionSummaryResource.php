<?php

namespace Narsil\Http\Resources\Summaries;

#region USE

use Illuminate\Http\Request;
use Narsil\Http\Resources\AbstractSummaryResource;
use Narsil\Models\Elements\Template;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class CollectionSummaryResource extends AbstractSummaryResource
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            self::HREF => route("collections.index", $this->{Template::HANDLE}),
            self::NAME => $this->{Template::NAME},
        ];
    }

    #endregion
}
