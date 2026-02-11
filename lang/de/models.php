<?php

#region USE

use Narsil\Base\Models\Users\UserConfiguration;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Configuration;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Storages\Asset;
use Narsil\Cms\Models\User;
use Narsil\Cms\Models\Users\UserBookmark;

#endregion

return [
    Asset::class => 'Asset',
    Block::class => 'Block',
    Configuration::class => 'Einstellungen',
    Entity::class => 'Entität',
    Field::class => 'Feld',
    Footer::class => 'Fußzeile',
    Header::class => 'Kopfzeile',
    Host::class => 'Host',
    Permission::class => 'Berechtigung',
    Role::class => 'Rolle',
    Site::class => 'Webseite',
    SitePage::class => 'Seite',
    Template::class => 'Vorlage',
    User::class => 'Benutzer',
    UserBookmark::class => 'Lesezeichen',
    UserConfiguration::class => 'Einstellungen',
];
