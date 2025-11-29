<?php

#region USE

use Narsil\Models\Configuration;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;
use Narsil\Models\Users\UserConfiguration;

#endregion

return [
    Block::class => 'Block',
    Configuration::class => 'Einstellungen',
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
