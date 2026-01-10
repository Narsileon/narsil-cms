<?php

namespace Narsil\Http\Resources\Collections;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Narsil\Http\Resources\SummaryResource;
use Narsil\Models\Collections\Template;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CollectionSummaryResource extends SummaryResource
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            self::HREF => route("collections.index", $this->{Template::TABLE_NAME}),
            self::NAME => Str::ucfirst($this->{Template::PLURAL}),
        ];
    }

    #endregion
}
