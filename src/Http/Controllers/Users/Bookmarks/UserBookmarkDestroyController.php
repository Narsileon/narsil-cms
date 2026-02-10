<?php

namespace Narsil\Cms\Http\Controllers\Users\Bookmarks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Users\UserBookmark;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserBookmarkDestroyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param UserBookmark $template
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, UserBookmark $userBookmark): RedirectResponse
    {
        if ($userBookmark->user_id !== Auth::id())
        {
            abort(403);
        }

        $userBookmark->delete();

        return back();
    }

    #endregion
}
