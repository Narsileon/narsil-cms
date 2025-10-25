<?php

namespace Narsil\Enums\Forms;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum MethodEnum: string
{
    use Enumerable;

    case GET = 'get';
    case PATCH = 'patch';
    case POST = 'post';
    case PUT = 'put';
}
