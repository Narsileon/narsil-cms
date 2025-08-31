<?php

namespace Narsil\Enums\Database;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum SessionEnum: string
{
    use Enumerable;

    case ALL = 'all';
    case CURRENT = 'current';
    case OTHERS = 'others';
}
