<?php

#region USE

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

#endregion

return [
    Block::TABLE => 'Blocks',
    Entity::TABLE => 'Entities',
    Field::TABLE => 'Fields',
    Footer::TABLE => 'Footers',
    Header::TABLE => 'Headers',
    Host::TABLE => 'Hosts',
    Permission::TABLE => 'Permissions',
    Role::TABLE => 'Roles',
    Site::VIRTUAL_TABLE => 'Websites',
    SitePage::TABLE => 'Website pages',
    Template::TABLE => 'Templates',
    User::TABLE => 'Users',
    UserBookmark::TABLE => 'Bookmarks',
];
