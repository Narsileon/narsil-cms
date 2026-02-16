<?php

#region USE

use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;

#endregion

return [
    Block::TABLE => [
        Block::HANDLE => 'Le handle par défaut. La valeur peut être remplacée par des templates et des blocs qui implémentent ce bloc.',
        Block::LABEL => 'Le libellé par défaut. La valeur peut être remplacée par des templates et des blocs qui implémentent ce bloc.',
    ],
    Field::TABLE => [
        Field::DESCRIPTION => 'La description par défaut. La valeur peut être remplacée par des templates et des blocs qui implémentent ce champ.',
        Field::HANDLE => 'Le handle par défaut. La valeur peut être remplacée par des templates et des blocs qui implémentent ce champ.',
        Field::LABEL => 'Le libellé par défaut. La valeur peut être remplacée par des templates et des blocs qui implémentent ce champ.',
    ],
    Host::TABLE => [
        Host::HOSTNAME => 'Le nom d\'hôte du site web, par exemple \'domain.com\' ou \'subdomain.domain.com\'.',
        Host::LABEL => 'Le libellé d\'affichage montré dans la barre latérale.',
    ],
    HostLocale::TABLE => [
        HostLocale::PATTERN => 'Le modèle des URLs, par exemple \':example\'.',
    ],
];
