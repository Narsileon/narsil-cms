<?php

namespace Narsil\Cms\Http\Middleware;

#region USE

use Narsil\Cms\Models\User;
use Narsil\Cms\Models\Users\UserConfiguration;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationMiddleware
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
        $userConfiguration = Auth::user()?->{User::RELATION_CONFIGURATION};

        if ($userConfiguration)
        {
            $this->setSessionColor($userConfiguration);
            $this->setSessionLanguage($userConfiguration);
            $this->setSessionRadius($userConfiguration);
            $this->setSessionTheme($userConfiguration);
        }

        return $next($request);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Set the color of the session.
     *
     * @param UserConfiguration $userConfiguration
     *
     * @return void
     */
    protected function setSessionColor(UserConfiguration $userConfiguration): void
    {
        if (!Session::has(UserConfiguration::COLOR))
        {
            $color = $userConfiguration->{UserConfiguration::COLOR};

            if ($color)
            {
                Session::put(UserConfiguration::COLOR, $color);
            }
        }
    }

    /**
     * Set the language of the session.
     *
     * @param UserConfiguration $userConfiguration
     *
     * @return void
     */
    protected function setSessionLanguage(UserConfiguration $userConfiguration): void
    {
        if (!Session::has(UserConfiguration::LANGUAGE))
        {
            $language = $userConfiguration->{UserConfiguration::LANGUAGE};

            if ($language)
            {
                Session::put(UserConfiguration::LANGUAGE, $language);
            }
        }
    }

    /**
     * Set the radius of the session.
     *
     * @param UserConfiguration $userConfiguration
     *
     * @return void
     */
    protected function setSessionRadius(UserConfiguration $userConfiguration): void
    {
        if (!Session::has(UserConfiguration::RADIUS))
        {
            $radius = $userConfiguration->{UserConfiguration::RADIUS};

            if ($radius)
            {
                Session::put(UserConfiguration::RADIUS, $radius);
            }
        }
    }

    /**
     * Set the theme of the session.
     *
     * @param UserConfiguration $userConfiguration
     *
     * @return void
     */
    protected function setSessionTheme(UserConfiguration $userConfiguration): void
    {
        if (!Session::has(UserConfiguration::THEME))
        {
            $theme = $userConfiguration->{UserConfiguration::THEME};

            if ($theme)
            {
                Session::put(UserConfiguration::THEME, $theme);
            }
        }
    }

    #endregion
}
