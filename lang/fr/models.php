<?php

#region USE

use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;

#endregion

return [
    Block::class => 'Bloc',
    Field::class => 'Champ',
    Footer::class => 'Pied de page',
    Header::class => 'En-tête',
    Host::class => 'Hôte',
    Permission::class => 'Permission',
    Role::class => 'Rôle',
    Template::class => 'Modèle',
    User::class => 'Utilisateur',
];
