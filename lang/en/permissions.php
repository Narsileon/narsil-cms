<?php

#region USE

use Narsil\Enums\Policies\PermissionEnum;

#endregion

return [
    PermissionEnum::CREATE->value => 'Create :model',
    PermissionEnum::DELETE_ANY->value => 'Delete any :table',
    PermissionEnum::DELETE->value => 'Delete :model',
    PermissionEnum::UPDATE->value => 'Update :model',
    PermissionEnum::VIEW_ANY->value => 'View any :table',
    PermissionEnum::VIEW->value => 'View :model',
];
