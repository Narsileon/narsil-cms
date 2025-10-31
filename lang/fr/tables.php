<?php

#region USE

use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;

#endregion

return [
    Block::TABLE => 'Blocs',
    Field::TABLE => 'Champs',
    Host::TABLE => 'Hôtes',
    Permission::TABLE => 'Permissions',
    Role::TABLE => 'Rôles',
    Template::TABLE => 'Modèles',
    User::TABLE => 'Utilisateurs',
];
