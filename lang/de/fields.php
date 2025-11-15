<?php

#region USE

use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\DateField;
use Narsil\Contracts\Fields\DatetimeField;
use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\FileField;
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

#endregion

return [
    ArrayField::class => 'Array',
    BuilderField::class => 'Builder',
    CheckboxField::class => 'Kontrollkästchen',
    DateField::class => 'Datum',
    DatetimeField::class => 'Datum und Zeit',
    EmailField::class => 'E-Mail',
    FileField::class => 'Datei',
    NumberField::class => 'Zahl',
    PasswordField::class => 'Passwort',
    RangeField::class => 'Bereich',
    RelationsField::class => 'Beziehungen',
    RichTextField::class => 'Rich-Text',
    SelectField::class => 'Auswahl',
    SwitchField::class => 'Schalter',
    TableField::class => 'Tabelle',
    TextField::class => 'Text',
    TextareaField::class => 'Textbereich',
    TimeField::class => 'Zeit',
    TreeField::class => 'Baumstruktur',
];
