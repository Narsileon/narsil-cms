<?php

namespace Narsil\Enums\Policies;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum PermissionEnum: string
{
    case CREATE     = 'create';
    case DELETE     = 'delete';
    case DELETE_ANY = 'deleteAny';
    case UPDATE     = 'update';
    case VIEW       = 'view';
    case VIEW_ANY   = 'viewAny';
}
