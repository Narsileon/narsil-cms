<?php

namespace Narsil\Cms\Http\Middleware;

#region USE

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Narsil\Base\Models\Users\UserConfiguration;
use Narsil\Base\Traits\HasSchemas;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SchemaMiddleware
{
    use HasSchemas;

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
        $schema = Session::get(UserConfiguration::SCHEMA, 'cms');

        if ($schema == 'public')
        {
            $schema = 'cms';
        }

        $this->setSearchPath($schema);

        return $next($request);
    }

    #endregion
}
