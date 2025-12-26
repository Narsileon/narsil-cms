<?php

#region USE

use Narsil\Models\Configuration;
use Narsil\Models\Entities\Entity;
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
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;
use Narsil\Models\Users\UserConfiguration;

#endregion

return [
    Block::class => 'block',
    Configuration::class => 'settings',
    Entity::class => 'entity',
    Field::class => 'field',
    Footer::class => 'footer',
    Form::class => 'form',
    Fieldset::class => 'fieldset',
    Input::class => 'input',
    Header::class => 'header',
    Host::class => 'host',
    Permission::class => 'permission',
    Role::class => 'role',
    Site::class => 'website',
    SitePage::class => 'page',
    Template::class => 'template',
    User::class => 'user',
    UserBookmark::class => 'bookmark',
    UserConfiguration::class => 'settings',
];
