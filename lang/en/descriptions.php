<?php

#region USE

use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Input;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;

#endregion

return [
    Block::TABLE => [
        Block::HANDLE => 'The default handle. The value can be overridden by templates and blocks that implement this block.',
        Block::LABEL => 'The default label. The value can be overridden by templates and blocks that implement this block.',
    ],
    Field::TABLE => [
        Field::DESCRIPTION => 'The default description. The value can be overridden by templates and blocks that implement this field.',
        Field::HANDLE => 'The default handle. The value can be overridden by templates and blocks that implement this field.',
        Field::LABEL => 'The default label. The value can be overridden by templates and blocks that implement this field.',
    ],
    Fieldset::TABLE => [
        Fieldset::HANDLE => 'The default handle. The value can be overridden by forms and fieldsets that implement this fieldset.',
        Fieldset::LABEL => 'The default label. The value can be overridden by forms and fieldsets that implement this fieldset.',
    ],
    Input::TABLE => [
        Input::DESCRIPTION => 'The default description. The value can be overridden by forms and fieldsets that implement this input.',
        Input::HANDLE => 'The default handle. The value can be overridden by forms and fieldsets that implement this input.',
        Input::LABEL => 'The default label. The value can be overridden by forms and fieldsets that implement this input.',
    ],
    Permission::TABLE => [
        Permission::LABEL => 'The display label shown to users.',
        Permission::NAME => 'The internal name for the permission.',
    ],
    Role::TABLE => [
        Role::LABEL => 'The display label shown to users.',
        Role::NAME => 'The internal name for the role.',
    ],
];
