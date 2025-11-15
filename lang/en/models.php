<?php

#region USE

use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;

#endregion

return [
    Block::class => 'Block',
    Field::class => 'Field',
    Footer::class => 'Footer',
    Header::class => 'Header',
    Host::class => 'Host',
    Permission::class => 'Permission',
    Role::class => 'Role',
    Site::class => 'Website',
    Template::class => 'Template',
    User::class => 'User',
    UserBookmark::class => 'Bookmark',
];
