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
];
