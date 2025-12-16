<?php

#region USE

use Narsil\Enums\Policies\PermissionEnum;

#endregion

return [
    PermissionEnum::CREATE->value => 'Créer des :table',
    PermissionEnum::DELETE_ANY->value => 'Supprimer des :table',
    PermissionEnum::DELETE->value => 'Supprimer des :table',
    PermissionEnum::UPDATE->value => 'Mettre à jour les :table',
    PermissionEnum::VIEW_ANY->value => 'Voir les :table',
    PermissionEnum::VIEW->value => 'Voir les :table',
];
