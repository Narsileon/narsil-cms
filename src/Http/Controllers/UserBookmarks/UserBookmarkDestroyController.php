<?php

namespace Narsil\Http\Controllers\UserBookmarks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Users\UserBookmark;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserBookmarkDestroyController extends AbstractController
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
