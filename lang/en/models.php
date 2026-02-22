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
use Narsil\Cms\Models\ValidationRule;

#endregion

return [
    Block::TABLE => 'block|blocks',
    Configuration::TABLE => 'settings',
    Entity::TABLE => 'entity|entities',
    Field::TABLE => 'field|fields',
    Footer::TABLE => 'footer|footers',
    FooterLink::TABLE => 'link|links',
    FooterSocialMedium::TABLE => 'social media',
    Header::TABLE => 'header|headers',
    Host::TABLE => 'host|hosts',
    HostLocale::TABLE => 'locale|locales',
    HostLocaleLanguage::TABLE => 'language|languages',
    Site::VIRTUAL_TABLE => 'website|websites',
    SitePage::TABLE => 'page|pages',
    Template::TABLE => 'template|templates',
    TemplateTab::TABLE => 'tab|tabs',
    ValidationRule::TABLE => 'validation rule|validation rules',
];
