<?php

namespace App\Http\Controllers\Sessions;

#region USE

use App\Http\Requests\Sessions\SessionLocaleUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SessionLocaleUpdateController extends Controller
{
    #region PUBLIC METHODS

    /**
     * @param SessionLocaleUpdateRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(SessionLocaleUpdateRequest $request): RedirectResponse
    {
        $locale = $request->validated(SessionLocaleUpdateRequest::LOCALE);

        Session::put(SessionLocaleUpdateRequest::LOCALE, $locale);

        return back();
    }

    #endregion
}
