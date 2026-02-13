<?php

#region USE

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
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Storages\Asset;
use Narsil\Cms\Models\Users\UserBookmark;
use Narsil\Cms\Models\ValidationRule;

#endregion

return [
    Asset::TABLE => 'Asset|Assets',
    Block::TABLE => 'Block|Blocks',
    Configuration::TABLE => 'Einstellungen',
    Entity::TABLE => 'Entität|Entitäten',
    Field::TABLE => 'Feld|Felder',
    Footer::TABLE => 'Fußzeile|Fußzeilen',
    FooterLink::TABLE => 'Link|Links',
    FooterSocialMedium::TABLE => 'Sozial Medium|Soziale Medien',
    Header::TABLE => 'Kopfzeile|Kopfzeilen',
    Host::TABLE => 'Host|Hosts',
    HostLocale::TABLE => 'Locale|Locales',
    HostLocaleLanguage::TABLE => 'Sprache|Sprachen',
    Site::VIRTUAL_TABLE => 'Webseite|Webseiten',
    SitePage::TABLE => 'Seite|Seiten',
    Template::TABLE => 'Vorlage|Vorlagen',
    TemplateTab::TABLE => 'Tab|Tabs',
    UserBookmark::TABLE => 'Lesezeichen',
    ValidationRule::TABLE => 'Validierungsregel|Validierungsregeln',
];
