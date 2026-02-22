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
    Block::TABLE => 'bloc|blocs',
    Configuration::TABLE => 'paramètres',
    Entity::TABLE => 'entité|entités',
    Field::TABLE => 'champ|champs',
    Footer::TABLE => 'pied de page|pieds de page',
    FooterLink::TABLE => 'lien|liens',
    FooterSocialMedium::TABLE => 'réseau social|réseaux sociaux',
    Header::TABLE => 'en-tête|en-têtes',
    Host::TABLE => 'hote|hôtes',
    HostLocale::TABLE => 'locale|locales',
    HostLocaleLanguage::TABLE => 'langage|langages',
    Site::VIRTUAL_TABLE => 'site web|sites web',
    SitePage::TABLE => 'page|pages',
    Template::TABLE => 'modèle|modèles',
    TemplateTab::TABLE => 'onglet|onglets',
    ValidationRule::TABLE => 'regle de validation|règles de validation',
];
