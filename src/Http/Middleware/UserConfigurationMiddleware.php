<?php

namespace Narsil\Http\Middleware;

#region USE

use Narsil\Models\User;
use Narsil\Models\Users\UserConfiguration;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class UserConfigurationMiddleware
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
        $userConfiguration = Auth::user()?->{User::RELATION_CONFIGURATION};

        if ($userConfiguration)
        {
            $this->setColor($userConfiguration);
            $this->setRadius($userConfiguration);
            $this->setTheme($userConfiguration);
        }

        return $next($request);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param UserConfiguration $userConfiguration
     *
     * @return void
     */
    protected function setColor(UserConfiguration $userConfiguration): void
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
     * @param UserConfiguration $userConfiguration
     *
     * @return void
     */
    protected function setRadius(UserConfiguration $userConfiguration): void
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
     * @param UserConfiguration $userConfiguration
     *
     * @return void
     */
    protected function setTheme(UserConfiguration $userConfiguration): void
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
