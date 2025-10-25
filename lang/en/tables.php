<?php

#region USE

use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;

#endregion

return [
    Block::TABLE => 'Blocks',
    Field::TABLE => 'Fields',
    Host::TABLE => 'Hosts',
    Permission::TABLE => 'Permissions',
    Role::TABLE => 'Roles',
    Template::TABLE => 'Templates',
    User::TABLE => 'Users',
];
