<?php

#region USE

use Narsil\Models\Configuration;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
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
    Block::TABLE => 'blocs',
    Configuration::TABLE => 'paramètres',
    Entity::TABLE => 'entités',
    Field::TABLE => 'champs',
    Footer::TABLE => 'pieds de page',
    Form::TABLE => 'formulaires',
    FormFieldset::TABLE => 'ensembles de champs',
    FormInput::TABLE => 'champs',
    Header::TABLE => 'en-têtes',
    Host::TABLE => 'hôtes',
    Permission::TABLE => 'permissions',
    Role::TABLE => 'rôles',
    Site::VIRTUAL_TABLE => 'sites web',
    SitePage::TABLE => 'pages de site web',
    Template::TABLE => 'modèles',
    User::TABLE => 'utilisateurs',
    UserBookmark::TABLE => 'signets',
    UserConfiguration::TABLE => 'paramètres',
];
