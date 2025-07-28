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

    \Narsil\Contracts\FormElements\CheckboxInput::class => \Narsil\Implementations\FormElements\CheckboxInput::class,
    \Narsil\Contracts\FormElements\DateInput::class => \Narsil\Implementations\FormElements\DateInput::class,
    \Narsil\Contracts\FormElements\EmailInput::class => \Narsil\Implementations\FormElements\EmailInput::class,
    \Narsil\Contracts\FormElements\NumberInput::class => \Narsil\Implementations\FormElements\NumberInput::class,
    \Narsil\Contracts\FormElements\PasswordInput::class => \Narsil\Implementations\FormElements\PasswordInput::class,
    \Narsil\Contracts\FormElements\RangeInput::class => \Narsil\Implementations\FormElements\RangeInput::class,
    \Narsil\Contracts\FormElements\RichTextInput::class => \Narsil\Implementations\FormElements\RichTextInput::class,
    \Narsil\Contracts\FormElements\SelectInput::class => \Narsil\Implementations\FormElements\SelectInput::class,
    \Narsil\Contracts\FormElements\SwitchInput::class => \Narsil\Implementations\FormElements\SwitchInput::class,
    \Narsil\Contracts\FormElements\TextInput::class => \Narsil\Implementations\FormElements\TextInput::class,
    \Narsil\Contracts\FormElements\TimeInput::class => \Narsil\Implementations\FormElements\TimeInput::class,
];
