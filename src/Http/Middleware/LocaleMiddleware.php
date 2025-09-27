<?php

namespace Narsil\Http\Middleware;

#region USE

use Narsil\Models\User;
use Narsil\Models\Users\UserConfiguration;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class LocaleMiddleware
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->setLocale();

        return $next($request);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function setLocale(): void
    {
        $locale = Session::get(UserConfiguration::LOCALE);

        if (!$locale)
        {
            $locale = Auth::user()?->{User::RELATION_CONFIGURATION}?->{UserConfiguration::LOCALE};

            if ($locale)
            {
                Session::put(UserConfiguration::LOCALE, $locale);
            }
        }

        if ($locale)
        {
            App::setLocale($locale);
        }
    }

    #endregion
}
