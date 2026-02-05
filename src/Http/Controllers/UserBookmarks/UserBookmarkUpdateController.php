<?php

namespace Narsil\Cms\Http\Controllers\UserBookmarks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\UserBookmarkRequest;
use Narsil\Cms\Models\Users\UserBookmark;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserBookmarkUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param UserBookmarkRequest $request
     * @param UserBookmark $template
     *
     * @return RedirectResponse
     */
    public function __invoke(UserBookmarkRequest $request, UserBookmark $userBookmark): RedirectResponse
    {
        if ($userBookmark->user_id !== Auth::id())
        {
            abort(403);
        }

        $attributes = $request->validated();

        $userBookmark->update($attributes);

        return back();
    }

    #endregion
}
