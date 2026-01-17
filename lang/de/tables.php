<?php

#region USE

use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\Template;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Configuration;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormStep;
use Narsil\Models\Forms\FormWebhook;
use Narsil\Models\Forms\Input;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterLink;
use Narsil\Models\Globals\FooterSocialMedium;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;
use Narsil\Models\Users\UserConfiguration;
use Narsil\Models\ValidationRule;

#endregion

return [
    Block::TABLE => 'Blocks',
    Configuration::TABLE => 'Einstellungen',
    Entity::TABLE => 'Entitäten',
    Field::TABLE => 'Felder',
    Fieldset::TABLE => 'Feldgruppen',
    Footer::TABLE => 'Fußzeilen',
    FooterLink::TABLE => 'Links',
    FooterSocialMedium::TABLE => 'Soziale Medien',
    Form::TABLE => 'Formulare',
    FormStep::TABLE => 'Tabs',
    FormWebhook::TABLE => 'Webhooks',
    Header::TABLE => 'Kopfzeilen',
    Host::TABLE => 'Hosts',
    HostLocale::TABLE => 'Locales',
    HostLocaleLanguage::TABLE => 'Sprachen',
    Input::TABLE => 'Eingaben',
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
];
