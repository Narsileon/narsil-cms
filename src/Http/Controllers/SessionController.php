<?php

namespace Narsil\Cms\Http\Controllers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Narsil\Base\Models\Users\Session;
use Narsil\Cms\Enums\Database\SessionEnum;
use Narsil\Cms\Http\Requests\SessionFormRequest;
use Narsil\Cms\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SessionController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(SessionFormRequest $request): RedirectResponse
    {
        $user = Auth::user();

        if (!$user)
        {
            abort(401);
        }

        $type = $request->validated(SessionFormRequest::TYPE);

        return match ($type)
        {
            SessionEnum::ALL->value     => $this->deleteAllSessions($request, $user),
            SessionEnum::CURRENT->value => $this->deleteCurrentSession($request),
            SessionEnum::OTHERS->value  => $this->deleteOtherSessions($request, $user),
        };
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    protected function deleteAllSessions(Request $request, User $user): RedirectResponse
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
            ->with('success', trans('narsil::toasts.success.logged_out_all'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    protected function deleteCurrentSession(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', trans('narsil::toasts.success.logged_out_current'));
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    protected function deleteOtherSessions(Request $request, User $user): RedirectResponse
    {
        $currentSessionId = $request->session()->getId();

        $sessions = $user->{User::RELATION_SESSIONS}
            ->where(Session::ID, '!=', $currentSessionId);

        $sessions->each->delete();

        return back()
            ->with('success', trans('narsil::toasts.success.logged_out_others'));
    }

    #endregion
}
