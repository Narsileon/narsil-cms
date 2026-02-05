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
    BuilderField::class => 'Constructeur',
    CheckboxField::class => 'Case à cocher',
    DateField::class => 'Date',
    DatetimeField::class => 'Date et heure',
    EmailField::class => 'Courriel',
    EntityField::class => 'Entité',
    FileField::class => 'Fichier',
    FormField::class => 'Formulaire',
    LinkField::class => 'Lien',
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
