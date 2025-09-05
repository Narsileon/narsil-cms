<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\UserBookmarkRequest;
use Narsil\Http\Resources\UserBookmarkCollection;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class UserBookmarkController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $userBookmarks = Auth::user()->{User::RELATION_BOOKMARKS};

        return response()->json(new UserBookmarkCollection($userBookmarks));
    }

    /**
     * @return RedirectResponse
     */
    public function store(UserBookmarkRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        UserBookmark::firstOrCreate(array_merge($attributes, [
            UserBookmark::USER_ID => Auth::id(),
        ]));

        return back();
    }

    /**
     * @param Request $request
     * @param UserBookmark $template
     *
     * @return RedirectResponse
     */
    public function update(Request $request, UserBookmark $userBookmark): RedirectResponse
    {
        if ($userBookmark->user_id !== Auth::id())
        {
            abort(403);
        }

        $attributes = $request->validated();

        $userBookmark->update($attributes);

        return back();
    }

    /**
     * @param Request $request
     * @param UserBookmark $template
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, UserBookmark $userBookmark): RedirectResponse
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
