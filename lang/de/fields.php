<?php

#region USE

use Narsil\Base\Models\Policies\Permission;
use Narsil\Base\Models\Policies\Role;
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
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;

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

    'descriptions' => [
        Block::TABLE => [
            Block::HANDLE => 'Der Standard-Handle. Der Wert kann von Templates und Blöcken überschrieben werden, die diesen Block implementieren.',
            Block::LABEL => 'Die Standardbezeichnung. Der Wert kann von Templates und Blöcken überschrieben werden, die diesen Block implementieren.',
        ],
        Field::TABLE => [
            Field::DESCRIPTION => 'Die Standardbeschreibung. Der Wert kann von Templates und Blöcken überschrieben werden, die dieses Feld implementieren.',
            Field::HANDLE => 'Der Standard-Handle. Der Wert kann von Templates und Blöcken überschrieben werden, die dieses Feld implementieren.',
            Field::LABEL => 'Die Standardbezeichnung. Der Wert kann von Templates und Blöcken überschrieben werden, die dieses Feld implementieren.',
        ],
        Host::TABLE => [
            Host::HOSTNAME => 'Der Hostname der Website, z. B. \'domain.com\' oder \'subdomain.domain.com\'.',
            Host::LABEL => 'Die in der Seitenleiste angezeigte Bezeichnung.',
        ],
        HostLocale::TABLE => [
            HostLocale::PATTERN => 'Das Muster der URLs, z. B. \':example\'.',
        ],
        Permission::TABLE => [
            Permission::LABEL => 'Die den Benutzern angezeigte Bezeichnung.',
            Permission::NAME => 'Der interne Name für die Berechtigung.',
        ],
        Role::TABLE => [
            Role::LABEL => 'Die den Benutzern angezeigte Bezeichnung.',
            Role::NAME => 'Der interne Name für die Rolle.',
        ],
    ],
];
