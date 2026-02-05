<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Field Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between field contracts and their concrete implementations.
    |
    */

    \Narsil\Cms\Contracts\Fields\ArrayField::class => \Narsil\Cms\Implementations\Fields\ArrayField::class,
    \Narsil\Cms\Contracts\Fields\BuilderField::class => \Narsil\Cms\Implementations\Fields\BuilderField::class,
    \Narsil\Cms\Contracts\Fields\CheckboxField::class => \Narsil\Cms\Implementations\Fields\CheckboxField::class,
    \Narsil\Cms\Contracts\Fields\DateField::class => \Narsil\Cms\Implementations\Fields\DateField::class,
    \Narsil\Cms\Contracts\Fields\DatetimeField::class => \Narsil\Cms\Implementations\Fields\DatetimeField::class,
    \Narsil\Cms\Contracts\Fields\EmailField::class => \Narsil\Cms\Implementations\Fields\EmailField::class,
    \Narsil\Cms\Contracts\Fields\EntityField::class => \Narsil\Cms\Implementations\Fields\EntityField::class,
    \Narsil\Cms\Contracts\Fields\FileField::class => \Narsil\Cms\Implementations\Fields\FileField::class,
    \Narsil\Cms\Contracts\Fields\FormField::class => \Narsil\Cms\Implementations\Fields\FormField::class,
    \Narsil\Cms\Contracts\Fields\LinkField::class => \Narsil\Cms\Implementations\Fields\LinkField::class,
    \Narsil\Cms\Contracts\Fields\NumberField::class => \Narsil\Cms\Implementations\Fields\NumberField::class,
    \Narsil\Cms\Contracts\Fields\PasswordField::class => \Narsil\Cms\Implementations\Fields\PasswordField::class,
    \Narsil\Cms\Contracts\Fields\RangeField::class => \Narsil\Cms\Implementations\Fields\RangeField::class,
    \Narsil\Cms\Contracts\Fields\RelationsField::class => \Narsil\Cms\Implementations\Fields\RelationsField::class,
    \Narsil\Cms\Contracts\Fields\RichTextField::class => \Narsil\Cms\Implementations\Fields\RichTextField::class,
    \Narsil\Cms\Contracts\Fields\SelectField::class => \Narsil\Cms\Implementations\Fields\SelectField::class,
    \Narsil\Cms\Contracts\Fields\SwitchField::class => \Narsil\Cms\Implementations\Fields\SwitchField::class,
    \Narsil\Cms\Contracts\Fields\TableField::class => \Narsil\Cms\Implementations\Fields\TableField::class,
    \Narsil\Cms\Contracts\Fields\TextField::class => \Narsil\Cms\Implementations\Fields\TextField::class,
    \Narsil\Cms\Contracts\Fields\TextareaField::class => \Narsil\Cms\Implementations\Fields\TextareaField::class,
    \Narsil\Cms\Contracts\Fields\TimeField::class => \Narsil\Cms\Implementations\Fields\TimeField::class,
    \Narsil\Cms\Contracts\Fields\TreeField::class => \Narsil\Cms\Implementations\Fields\TreeField::class,
];
