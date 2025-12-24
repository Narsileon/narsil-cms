<?php

namespace Narsil\Enums;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * Enumeration of model events.
 *
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum ModelEventEnum: string
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
