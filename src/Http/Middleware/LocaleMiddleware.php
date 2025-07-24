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
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class LocaleMiddleware
{
    #region CONSTANTS

    /**
     * @var string The name of the "locale" parameter.
     */
    public const LOCALE = 'locale';

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->setlocale($request);

        return $next($request);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param Request $request
     *
     * @return void
     */
    private function setlocale(Request $request): void
    {
        $locale = Session::get(self::LOCALE);

        if (!$locale)
        {
            $locale = Auth::user()?->{User::RELATION_CONFIGURATION}?->{UserConfiguration::LOCALE};

            if ($locale)
            {
                Session::put(self::LOCALE, $locale);
            }
        }

        if ($locale)
        {
            App::setLocale($locale);
        }
    }

    #endregion
}
