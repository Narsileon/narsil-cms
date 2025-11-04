<?php

#region USE

use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\User;

#endregion

return [
    Block::TABLE => 'Blocs',
    Entity::TABLE => 'Entités',
    Field::TABLE => 'Champs',
    Host::TABLE => 'Hôtes',
    Permission::TABLE => 'Permissions',
    Role::TABLE => 'Rôles',
    Site::VIRTUAL_TABLE => 'Sites web',
    SitePage::TABLE => 'Pages de site web',
    Template::TABLE => 'Modèles',
    User::TABLE => 'Utilisateurs',
];
