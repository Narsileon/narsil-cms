<?php

namespace Narsil\Cms\Http\Middleware;

#region USE

use Closure;
use Illuminate\Http\Request;
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
        $defaultSchema = $this->getDefaultSchema();
        $schema = $this->getCurrentSchema();

        if ($schema == 'public')
        {
            $schema = $defaultSchema;
        }

        $this->setSearchPath($schema);

        return $next($request);
    }

    #endregion
}
