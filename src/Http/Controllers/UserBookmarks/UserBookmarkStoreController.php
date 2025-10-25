<?php

namespace Narsil\Http\Controllers\UserBookmarks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\UserBookmarkRequest;
use Narsil\Models\Users\UserBookmark;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserBookmarkStoreController extends AbstractController
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
