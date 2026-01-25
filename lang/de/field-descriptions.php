<?php

#region USE

use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Field;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Input;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;

#endregion

return [
    Block::TABLE => [
        Block::HANDLE => 'Der Standard-Handle. Der Wert kann von Templates und Blöcken überschrieben werden, die diesen Block implementieren.',
        Block::LABEL => 'Die Standardbezeichnung. Der Wert kann von Templates und Blöcken überschrieben werden, die diesen Block implementieren.',
    ],
    Field::TABLE => [
        Field::DESCRIPTION => 'Die Standardbeschreibung. Der Wert kann von Templates und Blöcken überschrieben werden, die dieses Feld implementieren.',
        Field::HANDLE => 'Der Standard-Handle. Der Wert kann von Templates und Blöcken überschrieben werden, die dieses Feld implementieren.',
        Field::LABEL => 'Die Standardbezeichnung. Der Wert kann von Templates und Blöcken überschrieben werden, die dieses Feld implementieren.',
    ],
    Fieldset::TABLE => [
        Fieldset::HANDLE => 'Der Standard-Handle. Der Wert kann von Formularen und Feldgruppen überschrieben werden, die diese Feldgruppe implementieren.',
        Fieldset::LABEL => 'Die Standardbezeichnung. Der Wert kann von Formularen und Feldgruppen überschrieben werden, die diese Feldgruppe implementieren.',
    ],
    Host::TABLE => [
        Host::HOSTNAME => 'Der Hostname der Website, z. B. \'domain.com\' oder \'subdomain.domain.com\'.',
        Host::LABEL => 'Die in der Seitenleiste angezeigte Bezeichnung.',
    ],
    HostLocale::TABLE => [
        HostLocale::PATTERN => 'Das Muster der URLs, z. B. \':example\'.',
    ],
    Input::TABLE => [
        Input::DESCRIPTION => 'Die Standardbeschreibung. Der Wert kann von Formularen und Feldgruppen überschrieben werden, die dieses Eingabefeld implementieren.',
        Input::HANDLE => 'Der Standard-Handle. Der Wert kann von Formularen und Feldgruppen überschrieben werden, die dieses Eingabefeld implementieren.',
        Input::LABEL => 'Die Standardbezeichnung. Der Wert kann von Formularen und Feldgruppen überschrieben werden, die dieses Eingabefeld implementieren.',
    ],
    Permission::TABLE => [
        Permission::LABEL => 'Die den Benutzern angezeigte Bezeichnung.',
        Permission::NAME => 'Der interne Name für die Berechtigung.',
    ],
    Role::TABLE => [
        Role::LABEL => 'Die den Benutzern angezeigte Bezeichnung.',
        Role::NAME => 'Der interne Name für die Rolle.',
    ],
];
