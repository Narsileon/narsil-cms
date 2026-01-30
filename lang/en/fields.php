<?php

#region USE

use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\DateField;
use Narsil\Contracts\Fields\DatetimeField;
use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\EntityField;
use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\FormField;
use Narsil\Contracts\Fields\LinkField;
use Narsil\Contracts\Fields\NumberField;
use Narsil\Contracts\Fields\PasswordField;
use Narsil\Contracts\Fields\RangeField;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\RichTextField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\SwitchField;
use Narsil\Contracts\Fields\TableField;
use Narsil\Contracts\Fields\TextareaField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Fields\TimeField;
use Narsil\Contracts\Fields\TreeField;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Field;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Input;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;

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
        Fieldset::TABLE => [
            Fieldset::HANDLE => 'The default handle. The value can be overridden by forms and fieldsets that implement this fieldset.',
            Fieldset::LABEL => 'The default label. The value can be overridden by forms and fieldsets that implement this fieldset.',
        ],
        Host::TABLE => [
            Host::HOSTNAME => 'The hostname of the website, e.g. \'domain.com\' or \'subdomain.domain.com\'.',
            Host::LABEL => 'The display label shown in the sidebar.',
        ],
        HostLocale::TABLE => [
            HostLocale::PATTERN => 'The pattern of the URLs, e.g. \':example\'.',
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
    ]
];
