<?php

#region USE

use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\User;

#endregion

return [
    Block::TABLE => 'Blocks',
    Entity::TABLE => 'Entitäten',
    Field::TABLE => 'Felder',
    Footer::TABLE => 'Fußzeilen',
    Header::TABLE => 'Kopfzeilen',
    Host::TABLE => 'Hosts',
    Permission::TABLE => 'Berechtigungen',
    Role::TABLE => 'Rollen',
    Site::VIRTUAL_TABLE => 'Webseiten',
    SitePage::TABLE => 'Seiten von Webseiten',
    Template::TABLE => 'Vorlagen',
    User::TABLE => 'Benutzer',
];
