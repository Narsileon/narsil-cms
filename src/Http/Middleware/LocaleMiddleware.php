<?php

namespace Narsil\Http\Middleware;

#region USE

use Narsil\Models\Users\UserConfiguration;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->setApplicationLocale();

        return $next($request);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Set the locale of the application.
     *
     * @return void
     */
    protected function setApplicationLocale(): void
    {
        $language = Session::get(UserConfiguration::LANGUAGE);

        if ($language)
        {
            App::setLocale($language);
        }
    }

    #endregion
}
