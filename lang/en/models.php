<?php

#region USE

use Narsil\Models\Configuration;
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
use Narsil\Models\Users\UserConfiguration;

#endregion

return [
    Block::class => 'block',
    Configuration::class => 'settings',
    Entity::class => 'entity',
    Field::class => 'field',
    Footer::class => 'footer',
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
