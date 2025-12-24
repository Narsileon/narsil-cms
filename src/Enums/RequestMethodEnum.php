<?php

namespace Narsil\Enums;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * Enumeration of request methods.
 *
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum RequestMethodEnum: string
{
    use Enumerable;

    case DELETE = 'delted';
    case GET = 'get';
    case PATCH = 'patch';
    case POST = 'post';
    case PUT = 'put';
}
