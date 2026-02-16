<?php

#region USE

use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;

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
    Host::TABLE => [
        Host::HOSTNAME => 'Der Hostname der Website, z. B. \'domain.com\' oder \'subdomain.domain.com\'.',
        Host::LABEL => 'Die in der Seitenleiste angezeigte Bezeichnung.',
    ],
    HostLocale::TABLE => [
        HostLocale::PATTERN => 'Das Muster der URLs, z. B. \':example\'.',
    ],
];
