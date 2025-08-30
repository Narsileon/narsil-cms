<?php

#region USE

use Narsil\Contracts\Fields\CheckboxInput;
use Narsil\Contracts\Fields\DateInput;
use Narsil\Contracts\Fields\EmailInput;
use Narsil\Contracts\Fields\FileInput;
use Narsil\Contracts\Fields\NumberInput;
use Narsil\Contracts\Fields\PasswordInput;
use Narsil\Contracts\Fields\RangeInput;
use Narsil\Contracts\Fields\RelationsInput;
use Narsil\Contracts\Fields\RichTextInput;
use Narsil\Contracts\Fields\SectionElement;
use Narsil\Contracts\Fields\SelectInput;
use Narsil\Contracts\Fields\SwitchInput;
use Narsil\Contracts\Fields\TableInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Fields\TimeInput;

#endregion

return [
    CheckboxInput::class => 'Checkbox',
    DateInput::class => 'Date',
    EmailInput::class => 'Email',
    FileInput::class => 'File',
    NumberInput::class => 'Number',
    PasswordInput::class => 'Password',
    RangeInput::class => 'Range',
    RelationsInput::class => 'Relations',
    RichTextInput::class => 'Rich Text',
    SectionElement::class => 'Section',
    SelectInput::class => 'Select',
    SwitchInput::class => 'Switch',
    TableInput::class => 'Table',
    TextInput::class => 'Text',
    TimeInput::class => 'Time',
];
