<?php

#region USE

use Narsil\Enums\DiskEnum;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\Template;
use Narsil\Models\Configuration;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\Input;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Storages\Media;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;
use Narsil\Models\Users\UserConfiguration;

#endregion

return [
    Block::class => 'Block',
    Configuration::class => 'Einstellungen',
    Entity::class => 'Entität',
    Field::class => 'Feld',
    Footer::class => 'Fußzeile',
    Form::class => 'Formular',
    Fieldset::class => 'Feldgruppe',
    Input::class => 'Eingabe',
    Header::class => 'Kopfzeile',
    Host::class => 'Host',
    Media::class => 'Datei',
    Permission::class => 'Berechtigung',
    Role::class => 'Rolle',
    Site::class => 'Webseite',
    SitePage::class => 'Seite',
    Template::class => 'Vorlage',
    User::class => 'Benutzer',
    UserBookmark::class => 'Lesezeichen',
    UserConfiguration::class => 'Einstellungen',

    DiskEnum::DOCUMENTS->value => 'Dokument',
    DiskEnum::IMAGES->value => 'Bild',
    DiskEnum::VIDEOS->value => 'Video',
];
