<?php

namespace Narsil\Cms\Enums\Database;

#region USE

use Narsil\Base\Traits\Enumerable;

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
