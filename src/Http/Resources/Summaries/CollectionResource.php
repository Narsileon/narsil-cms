<?php

namespace Narsil\Http\Resources\Summaries;

#region USE

use Illuminate\Http\Request;
use Narsil\Models\Elements\Template;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class CollectionResource extends AbstractSummaryResource
{
    #region CONSTRUCTOR

    /**
     * @param Template $resource
     *
     * @return void
     */
    public function __construct(Template $resource)
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
            Template::HANDLE => $this->{Template::HANDLE},
            Template::ID => $this->{Template::ID},
            Template::NAME => $this->{Template::NAME},

            self::HREF => route("collections.index", $this->{Template::HANDLE}),
        ];
    }

    #endregion
}
