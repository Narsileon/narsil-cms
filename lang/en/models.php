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
    Block::class => 'Block',
    Configuration::class => 'Settings',
    Field::class => 'Field',
    Footer::class => 'Footer',
    Header::class => 'Header',
    Host::class => 'Host',
    Permission::class => 'Permission',
    Role::class => 'Role',
    Site::class => 'Website',
    SitePage::class => 'Page',
    Template::class => 'Template',
    User::class => 'User',
    UserBookmark::class => 'Bookmark',
    UserConfiguration::class => 'Settings',
];
