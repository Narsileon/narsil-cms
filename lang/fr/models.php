<?php

#region USE

use Dom\Entity;
use Narsil\Enums\DiskEnum;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\Template;
use Narsil\Models\Configuration;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\Input;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Storages\Media;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;
use Narsil\Models\Users\UserConfiguration;

#endregion

return [
    Block::class => 'bloc',
    Configuration::class => 'paramètres',
    Entity::class => 'entité',
    Field::class => 'champ',
    Fieldset::class => 'ensemble de champs',
    Footer::class => 'pied de page',
    Form::class => 'formulaire',
    Header::class => 'en-tête',
    Host::class => 'hôte',
    Input::class => 'entrée',
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
