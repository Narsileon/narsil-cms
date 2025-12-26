<?php

#region USE

use Narsil\Models\Configuration;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\Input;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterLink;
use Narsil\Models\Globals\FooterSocialMedium;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;
use Narsil\Models\Users\UserConfiguration;
use Narsil\Models\ValidationRule;

#endregion

return [
    Block::TABLE => 'blocks',
    Configuration::TABLE => 'settings',
    Entity::TABLE => 'entities',
    Field::TABLE => 'fields',
    Footer::TABLE => 'footers',
    FooterLink::TABLE => 'links',
    FooterSocialMedium::TABLE => 'social media',
    Form::TABLE => 'forms',
    Fieldset::TABLE => 'fieldsets',
    Input::TABLE => 'inputs',
    Header::TABLE => 'headers',
    Host::TABLE => 'hosts',
    HostLocale::TABLE => 'locales',
    Permission::TABLE => 'permissions',
    Role::TABLE => 'roles',
    Site::VIRTUAL_TABLE => 'websites',
    SitePage::TABLE => 'website pages',
    Template::TABLE => 'templates',
    User::TABLE => 'users',
    UserBookmark::TABLE => 'bookmarks',
    UserConfiguration::TABLE => 'settings',
    ValidationRule::TABLE => 'validation rules',
];
