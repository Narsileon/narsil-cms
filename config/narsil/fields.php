<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Field Implementations
    |--------------------------------------------------------------------------
    |
    | This file defines a mapping between field contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\Fields\ArrayField::class => \Narsil\Implementations\Fields\ArrayField::class,
    \Narsil\Contracts\Fields\CheckboxField::class => \Narsil\Implementations\Fields\CheckboxField::class,
    \Narsil\Contracts\Fields\DateField::class => \Narsil\Implementations\Fields\DateField::class,
    \Narsil\Contracts\Fields\EmailField::class => \Narsil\Implementations\Fields\EmailField::class,
    \Narsil\Contracts\Fields\FileField::class => \Narsil\Implementations\Fields\FileField::class,
    \Narsil\Contracts\Fields\NumberField::class => \Narsil\Implementations\Fields\NumberField::class,
    \Narsil\Contracts\Fields\PasswordField::class => \Narsil\Implementations\Fields\PasswordField::class,
    \Narsil\Contracts\Fields\RangeField::class => \Narsil\Implementations\Fields\RangeField::class,
    \Narsil\Contracts\Fields\RelationsField::class => \Narsil\Implementations\Fields\RelationsField::class,
    \Narsil\Contracts\Fields\RichTextField::class => \Narsil\Implementations\Fields\RichTextField::class,
    \Narsil\Contracts\Fields\SelectField::class => \Narsil\Implementations\Fields\SelectField::class,
    \Narsil\Contracts\Fields\SwitchField::class => \Narsil\Implementations\Fields\SwitchField::class,
    \Narsil\Contracts\Fields\TableField::class => \Narsil\Implementations\Fields\TableField::class,
    \Narsil\Contracts\Fields\TextField::class => \Narsil\Implementations\Fields\TextField::class,
    \Narsil\Contracts\Fields\TimeField::class => \Narsil\Implementations\Fields\TimeField::class,
    \Narsil\Contracts\Fields\TreeField::class => \Narsil\Implementations\Fields\TreeField::class,
];
