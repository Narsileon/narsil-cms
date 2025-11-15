<?php

#region USE

use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;

#endregion

return [
    Block::class => 'Block',
    Field::class => 'Feld',
    Footer::class => 'Fußzeile',
    Header::class => 'Kopfzeile',
    Host::class => 'Host',
    Permission::class => 'Berechtigung',
    Role::class => 'Rolle',
    Site::class => 'Webseite',
    Template::class => 'Vorlage',
    User::class => 'Benutzer',
    UserBookmark::class => 'Lesezeichen',
];
