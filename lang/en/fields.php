<?php

#region USE

use Narsil\Cms\Contracts\Fields\ArrayField;
use Narsil\Cms\Contracts\Fields\BuilderField;
use Narsil\Cms\Contracts\Fields\CheckboxField;
use Narsil\Cms\Contracts\Fields\DateField;
use Narsil\Cms\Contracts\Fields\DatetimeField;
use Narsil\Cms\Contracts\Fields\EmailField;
use Narsil\Cms\Contracts\Fields\EntityField;
use Narsil\Cms\Contracts\Fields\FileField;
use Narsil\Cms\Contracts\Fields\FormField;
use Narsil\Cms\Contracts\Fields\LinkField;
use Narsil\Cms\Contracts\Fields\NumberField;
use Narsil\Cms\Contracts\Fields\PasswordField;
use Narsil\Cms\Contracts\Fields\RangeField;
use Narsil\Cms\Contracts\Fields\RelationsField;
use Narsil\Cms\Contracts\Fields\RichTextField;
use Narsil\Cms\Contracts\Fields\SelectField;
use Narsil\Cms\Contracts\Fields\SwitchField;
use Narsil\Cms\Contracts\Fields\TableField;
use Narsil\Cms\Contracts\Fields\TextareaField;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Contracts\Fields\TimeField;
use Narsil\Cms\Contracts\Fields\TreeField;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Models\Policies\Role;

#endregion

return [
    ArrayField::class => 'Array',
    BuilderField::class => 'Builder',
    CheckboxField::class => 'Checkbox',
    DateField::class => 'Date',
    DatetimeField::class => 'Datetime',
    EmailField::class => 'Email',
    EntityField::class => 'Entity',
    FileField::class => 'File',
    FormField::class => 'Form',
    LinkField::class => 'Link',
    NumberField::class => 'Number',
    PasswordField::class => 'Password',
    RangeField::class => 'Range',
    RelationsField::class => 'Relations',
    RichTextField::class => 'Rich text',
    SelectField::class => 'Select',
    SwitchField::class => 'Switch',
    TableField::class => 'Table',
    TextField::class => 'Text',
    TextareaField::class => 'Textarea',
    TimeField::class => 'Time',
    TreeField::class => 'Tree',

    'descriptions' => [
        Block::TABLE => [
            Block::HANDLE => 'The default handle. The value can be overridden by templates and blocks that implement this block.',
            Block::LABEL => 'The default label. The value can be overridden by templates and blocks that implement this block.',
        ],
        Field::TABLE => [
            Field::DESCRIPTION => 'The default description. The value can be overridden by templates and blocks that implement this field.',
            Field::HANDLE => 'The default handle. The value can be overridden by templates and blocks that implement this field.',
            Field::LABEL => 'The default label. The value can be overridden by templates and blocks that implement this field.',
        ],
        Host::TABLE => [
            Host::HOSTNAME => 'The hostname of the website, e.g. \'domain.com\' or \'subdomain.domain.com\'.',
            Host::LABEL => 'The display label shown in the sidebar.',
        ],
        HostLocale::TABLE => [
            HostLocale::PATTERN => 'The pattern of the URLs, e.g. \':example\'.',
        ],
        Permission::TABLE => [
            Permission::LABEL => 'The display label shown to users.',
            Permission::NAME => 'The internal name for the permission.',
        ],
        Role::TABLE => [
            Role::LABEL => 'The display label shown to users.',
            Role::NAME => 'The internal name for the role.',
        ],
    ]
];
