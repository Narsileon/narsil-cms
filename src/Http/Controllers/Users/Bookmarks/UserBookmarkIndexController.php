<?php

namespace Narsil\Cms\Http\Controllers\Users\Bookmarks;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Narsil\Cms\Http\Collections\UserBookmarkCollection;
use Narsil\Cms\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserBookmarkIndexController
{
    #region PUBLIC METHODS

    /**
     * @return UserBookmarkCollection
     */
    public function __invoke(Request $request): UserBookmarkCollection
    {
        $userBookmarks = Auth::user()->{User::RELATION_BOOKMARKS};

        return new UserBookmarkCollection($userBookmarks);
    }

    #endregion
}
