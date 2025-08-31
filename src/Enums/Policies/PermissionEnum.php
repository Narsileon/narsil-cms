<?php

namespace Narsil\Enums\Policies;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum PermissionEnum: string
{
    use Enumerable;

    case CREATE     = 'create';
    case DELETE     = 'delete';
    case DELETE_ANY = 'deleteAny';
    case UPDATE     = 'update';
    case VIEW       = 'view';
    case VIEW_ANY   = 'viewAny';
}
