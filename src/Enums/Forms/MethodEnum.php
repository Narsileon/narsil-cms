<?php

namespace Narsil\Enums\Forms;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum MethodEnum: string
{
    use Enumerable;

    case GET = 'get';
    case PATCH = 'patch';
    case POST = 'post';
    case PUT = 'put';
}
