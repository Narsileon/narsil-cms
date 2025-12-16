<?php

#region USE

use Narsil\Enums\Policies\PermissionEnum;

#endregion

return [
    PermissionEnum::CREATE->value => ':model erstellen',
    PermissionEnum::DELETE_ANY->value => 'Alle :table löschen',
    PermissionEnum::DELETE->value => ':model löschen',
    PermissionEnum::UPDATE->value => ':model aktualisieren',
    PermissionEnum::VIEW_ANY->value => 'Alle :table anzeigen',
    PermissionEnum::VIEW->value => ':model anzeigen',
];
