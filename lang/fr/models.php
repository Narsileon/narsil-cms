<?php

#region USE

use Dom\Entity;
use Narsil\Models\Configuration;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Models\Forms\FormInput;
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
    Block::class => 'bloc',
    Configuration::class => 'paramètres',
    Entity::class => 'entité',
    Field::class => 'champ',
    Footer::class => 'pied de page',
    Form::class => 'formulaire',
    FormFieldset::class => 'ensemble de champs',
    FormInput::class => 'champ',
    Header::class => 'en-tête',
    Host::class => 'hôte',
    Permission::class => 'permission',
    Role::class => 'rôle',
    Site::class => 'site web',
    SitePage::class => 'page',
    Template::class => 'modèle',
    User::class => 'utilisateur',
    UserBookmark::class => 'signet',
    UserConfiguration::class => 'paramètres',
];
