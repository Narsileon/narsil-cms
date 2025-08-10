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

    \Narsil\Contracts\Fields\BuilderElement::class => \Narsil\Implementations\Fields\BuilderElement::class,
    \Narsil\Contracts\Fields\CheckboxInput::class => \Narsil\Implementations\Fields\CheckboxInput::class,
    \Narsil\Contracts\Fields\DateInput::class => \Narsil\Implementations\Fields\DateInput::class,
    \Narsil\Contracts\Fields\EmailInput::class => \Narsil\Implementations\Fields\EmailInput::class,
    \Narsil\Contracts\Fields\FileInput::class => \Narsil\Implementations\Fields\FileInput::class,
    \Narsil\Contracts\Fields\NumberInput::class => \Narsil\Implementations\Fields\NumberInput::class,
    \Narsil\Contracts\Fields\PasswordInput::class => \Narsil\Implementations\Fields\PasswordInput::class,
    \Narsil\Contracts\Fields\RangeInput::class => \Narsil\Implementations\Fields\RangeInput::class,
    \Narsil\Contracts\Fields\RelationsInput::class => \Narsil\Implementations\Fields\RelationsInput::class,
    \Narsil\Contracts\Fields\RichTextInput::class => \Narsil\Implementations\Fields\RichTextInput::class,
    \Narsil\Contracts\Fields\SectionElement::class => \Narsil\Implementations\Fields\SectionElement::class,
    \Narsil\Contracts\Fields\SelectInput::class => \Narsil\Implementations\Fields\SelectInput::class,
    \Narsil\Contracts\Fields\SwitchInput::class => \Narsil\Implementations\Fields\SwitchInput::class,
    \Narsil\Contracts\Fields\TableInput::class => \Narsil\Implementations\Fields\TableInput::class,
    \Narsil\Contracts\Fields\TextInput::class => \Narsil\Implementations\Fields\TextInput::class,
    \Narsil\Contracts\Fields\TimeInput::class => \Narsil\Implementations\Fields\TimeInput::class,
];
