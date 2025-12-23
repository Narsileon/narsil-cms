<?php

namespace Narsil\Enums\Database;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum EventEnum: string
{
    use Enumerable;

    case CREATED = 'created';
    case DELETED = 'deleted';
    case DELETED_MANY = 'deleted_many';
    case REPLICATED = 'replicated';
    case REPLICATED_MANY = 'replicated_many';
    case RESTORED = 'restored';
    case UPDATED = 'updated';
}
