<?php

namespace App\Http\Controllers\Sessions;

#region USE

use App\Enums\SessionEnum;
use App\Http\Requests\Sessions\SessionDeleteRequest;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SessionDeleteController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(SessionDeleteRequest $request): RedirectResponse
    {
        $user = Auth::user();

        if (!$user)
        {
            abort(401);
        }

        $type = $request->validated(SessionDeleteRequest::TYPE);

        return match ($type)
        {
            SessionEnum::ALL->value     => $this->deleteAllSessions($request, $user),
            SessionEnum::CURRENT->value => $this->deleteCurrentSession($request),
            SessionEnum::OTHERS->value  => $this->deleteOtherSessions($request, $user),
        };
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    private function deleteAllSessions(Request $request, User $user): RedirectResponse
    {
        $currentSessionId = $request->session()->getId();

        $sessions = $user->{User::RELATION_SESSIONS}
            ->where(Session::ID, '!=', $currentSessionId);

        $sessions->each->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', trans('toasts.success.sessions.deleted_all'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    private function deleteCurrentSession(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', trans('toasts.success.sessions.deleted_current'));
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    private function deleteOtherSessions(Request $request, User $user): RedirectResponse
    {
        $currentSessionId = $request->session()->getId();

        $sessions = $user->{User::RELATION_SESSIONS}
            ->where(Session::ID, '!=', $currentSessionId);

        $sessions->each->delete();

        return back()
            ->with('success', trans('toasts.success.sessions.deleted_others'));
    }

    #endregion
}
