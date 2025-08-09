<?php

namespace Narsil\Enums\Policies;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
