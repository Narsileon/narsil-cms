<?php

#region USE

use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Forms\Fieldset;
use Narsil\Cms\Models\Forms\Input;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Models\Policies\Role;

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
    Fieldset::TABLE => [
        Fieldset::HANDLE => 'Le handle par défaut. La valeur peut être remplacée par des formulaires et des groupes de champs qui implémentent ce groupe de champs.',
        Fieldset::LABEL => 'Le libellé par défaut. La valeur peut être remplacée par des formulaires et des groupes de champs qui implémentent ce groupe de champs.',
    ],
    Host::TABLE => [
        Host::HOSTNAME => 'Le nom d\'hôte du site web, par exemple \'domain.com\' ou \'subdomain.domain.com\'.',
        Host::LABEL => 'Le libellé d\'affichage montré dans la barre latérale.',
    ],
    HostLocale::TABLE => [
        HostLocale::PATTERN => 'Le modèle des URLs, par exemple \':example\'.',
    ],
    Input::TABLE => [
        Input::DESCRIPTION => 'La description par défaut. La valeur peut être remplacée par des formulaires et des groupes de champs qui implémentent ce champ de saisie.',
        Input::HANDLE => 'Le handle par défaut. La valeur peut être remplacée par des formulaires et des groupes de champs qui implémentent ce champ de saisie.',
        Input::LABEL => 'Le libellé par défaut. La valeur peut être remplacée par des formulaires et des groupes de champs qui implémentent ce champ de saisie.',
    ],
    Permission::TABLE => [
        Permission::LABEL => 'Le libellé affiché aux utilisateurs.',
        Permission::NAME => 'Le nom interne de la permission.',
    ],
    Role::TABLE => [
        Role::LABEL => 'Le libellé affiché aux utilisateurs.',
        Role::NAME => 'Le nom interne du rôle.',
    ],
];
