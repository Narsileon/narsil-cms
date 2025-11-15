<?php

#region USE

use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;

#endregion

return [
    Block::TABLE => 'Blocs',
    Entity::TABLE => 'Entités',
    Field::TABLE => 'Champs',
    Footer::TABLE => 'Pieds de page',
    Header::TABLE => 'En-têtes',
    Host::TABLE => 'Hôtes',
    Permission::TABLE => 'Permissions',
    Role::TABLE => 'Rôles',
    Site::VIRTUAL_TABLE => 'Sites web',
    SitePage::TABLE => 'Pages de site web',
    Template::TABLE => 'Modèles',
    User::TABLE => 'Utilisateurs',
    UserBookmark::TABLE => 'Signets',
];
