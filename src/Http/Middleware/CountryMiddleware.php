<?php

namespace Narsil\Http\Middleware;

#region USE

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Narsil\Models\Hosts\HostLocale;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CountryMiddleware
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
        $country = $request->query(HostLocale::COUNTRY);

        if (!$country)
        {
            if (!Session::has(HostLocale::COUNTRY))
            {
                Session::put(HostLocale::COUNTRY, 'default');
            }

            return redirect()->route(
                $request->route()->getName(),
                [
                    ...$request->route()->parameters(),
                    ...$request->query(),
                    HostLocale::COUNTRY => Session::get(HostLocale::COUNTRY),
                ]
            );
        }
        else
        {
            Session::put(HostLocale::COUNTRY, $country);
        }

        return $next($request);
    }

    #endregion
}
