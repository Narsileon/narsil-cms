<?php

#region USE

use Narsil\Models\Configuration;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;
use Narsil\Models\Users\UserConfiguration;

#endregion

return [
    Block::class => 'Bloc',
    Configuration::class => 'Paramètres',
    Field::class => 'Champ',
    Footer::class => 'Pied de page',
    Header::class => 'En-tête',
    Host::class => 'Hôte',
    Permission::class => 'Permission',
    Role::class => 'Rôle',
    Site::class => 'Site web',
    SitePage::class => 'Page',
    Template::class => 'Modèle',
    User::class => 'Utilisateur',
    UserBookmark::class => 'Signet',
    UserConfiguration::class => 'Paramètres',
];
