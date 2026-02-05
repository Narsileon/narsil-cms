<?php

#region USE

use Narsil\Cms\Enums\DiskEnum;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Configuration;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Forms\Fieldset;
use Narsil\Cms\Models\Forms\Form;
use Narsil\Cms\Models\Forms\Input;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Storages\Media;
use Narsil\Cms\Models\User;
use Narsil\Cms\Models\Users\UserBookmark;
use Narsil\Cms\Models\Users\UserConfiguration;

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
