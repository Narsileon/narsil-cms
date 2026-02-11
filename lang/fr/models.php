<?php

#region USE

use Narsil\Base\Models\Users\UserConfiguration;
use Narsil\Cms\Enums\DiskEnum;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Configuration;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Storages\Media;
use Narsil\Cms\Models\User;
use Narsil\Cms\Models\Users\UserBookmark;

#endregion

return [
    Block::class => 'bloc',
    Configuration::class => 'paramètres',
    Entity::class => 'entité',
    Field::class => 'champ',
    Footer::class => 'pied de page',
    Header::class => 'en-tête',
    Host::class => 'hôte',
    Media::class => 'fichier',
    Permission::class => 'permission',
    Role::class => 'rôle',
    Site::class => 'site web',
    SitePage::class => 'page',
    Template::class => 'modèle',
    User::class => 'utilisateur',
    UserBookmark::class => 'signet',
    UserConfiguration::class => 'paramètres',

    DiskEnum::DOCUMENTS->value => 'document',
    DiskEnum::IMAGES->value => 'image',
    DiskEnum::VIDEOS->value => 'vidéo',
];
