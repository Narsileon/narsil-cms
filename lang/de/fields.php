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
    CheckboxField::class => 'Kontrollkästchen',
    DateField::class => 'Datum',
    DatetimeField::class => 'Datum und Zeit',
    EmailField::class => 'E-Mail',
    EntityField::class => 'Entität',
    FileField::class => 'Datei',
    FormField::class => 'Formular',
    LinkField::class => 'Link',
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
