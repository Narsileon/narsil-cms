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
    Block::class => 'Block',
    Field::class => 'Field',
    Host::class => 'Host',
    Permission::class => 'Permission',
    Role::class => 'Role',
    Template::class => 'Template',
    User::class => 'User',
];
