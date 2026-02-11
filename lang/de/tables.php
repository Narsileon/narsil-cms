<?php

#region USE

use Narsil\Base\Models\Users\UserConfiguration;
use Narsil\Cms\Enums\DiskEnum;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Configuration;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;
use Narsil\Cms\Models\Globals\FooterSocialMedium;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Storages\Media;
use Narsil\Cms\Models\User;
use Narsil\Cms\Models\Users\UserBookmark;
use Narsil\Cms\Models\ValidationRule;

#endregion

return [
    Block::TABLE => 'Blocks',
    Configuration::TABLE => 'Einstellungen',
    Entity::TABLE => 'Entitäten',
    Field::TABLE => 'Felder',
    Footer::TABLE => 'Fußzeilen',
    FooterLink::TABLE => 'Links',
    FooterSocialMedium::TABLE => 'Soziale Medien',
    Header::TABLE => 'Kopfzeilen',
    Host::TABLE => 'Hosts',
    HostLocale::TABLE => 'Locales',
    HostLocaleLanguage::TABLE => 'Sprachen',
    Media::TABLE => 'Medien',
    Permission::TABLE => 'Berechtigungen',
    Role::TABLE => 'Rollen',
    Site::VIRTUAL_TABLE => 'Webseiten',
    SitePage::TABLE => 'Seiten',
    Template::TABLE => 'Vorlagen',
    TemplateTab::TABLE => 'Tabs',
    User::TABLE => 'Benutzer',
    UserBookmark::TABLE => 'Lesezeichen',
    UserConfiguration::TABLE => 'Einstellungen',
    ValidationRule::TABLE => 'Validierungsregeln',

    DiskEnum::DOCUMENTS->value => 'Dokumente',
    DiskEnum::IMAGES->value => 'Bilder',
    DiskEnum::VIDEOS->value => 'Videos',
];
