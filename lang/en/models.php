<?php

#region USE

use Narsil\Base\Models\Users\UserConfiguration;
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
use Narsil\Cms\Models\Storages\Asset;
use Narsil\Cms\Models\User;
use Narsil\Cms\Models\Users\UserBookmark;

#endregion

return [
    Asset::class => 'asset',
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
