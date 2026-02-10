<?php

namespace Narsil\Cms\Http\Controllers\Users\Bookmarks;

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
class UserBookmarkStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param UserBookmarkRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(UserBookmarkRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        UserBookmark::firstOrCreate(array_merge($attributes, [
            UserBookmark::USER_ID => Auth::id(),
        ]));

        return back();
    }

    #endregion
}
