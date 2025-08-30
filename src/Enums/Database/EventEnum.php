<?php

namespace Narsil\Enums\Database;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum EventEnum: string
{
    use Enumerable;

    case CREATED = 'created';
    case DELETED = 'deleted';
    case RESTORED = 'restored';
    case UPDATED = 'updated';
}
