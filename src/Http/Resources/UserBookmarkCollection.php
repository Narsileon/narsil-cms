<?php

namespace Narsil\Http\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;
use Narsil\Models\Users\UserBookmark;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class UserBookmarkCollection extends ResourceCollection
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): JsonSerializable
    {
        return $this->collection->map(function ($item)
        {
            return [
                UserBookmark::ID => $item->{UserBookmark::ID},
                UserBookmark::NAME => $item->{UserBookmark::NAME},
                UserBookmark::URL => $item->{UserBookmark::URL},
            ];
        });
    }

    #endregion
}
