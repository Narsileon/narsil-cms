<?php

#region USE

use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\DateField;
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
    BuilderField::class => 'Constructeur',
    CheckboxField::class => 'Case à cocher',
    DateField::class => 'Date',
    EmailField::class => 'Courriel',
    FileField::class => 'Fichier',
    NumberField::class => 'Nombre',
    PasswordField::class => 'Mot de passe',
    RangeField::class => 'Plage',
    RelationsField::class => 'Relations',
    RichTextField::class => 'Éditeur de texte',
    SelectField::class => 'Liste déroulante',
    SwitchField::class => 'Interrupteur',
    TableField::class => 'Tableau',
    TextField::class => 'Texte',
    TextareaField::class => 'Zone de texte',
    TimeField::class => 'Heure',
    TreeField::class => 'Arborescence',
];
