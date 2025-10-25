<?php

namespace Narsil\Enums\Database;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum SessionEnum: string
{
    use Enumerable;

    case ALL = 'all';
    case CURRENT = 'current';
    case OTHERS = 'others';
}
