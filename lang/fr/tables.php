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
    Block::TABLE => 'blocs',
    Configuration::TABLE => 'paramètres',
    Entity::TABLE => 'entités',
    Field::TABLE => 'champs',
    Fieldset::TABLE => 'ensembles de champs',
    Footer::TABLE => 'pieds de page',
    FooterLink::TABLE => 'liens',
    FooterSocialMedium::TABLE => 'réseaux sociaux',
    Form::TABLE => 'formulaires',
    FormStep::TABLE => 'onglets',
    FormWebhook::TABLE => 'webhooks',
    Header::TABLE => 'en-têtes',
    Host::TABLE => 'hôtes',
    HostLocale::TABLE => 'locales',
    HostLocaleLanguage::TABLE => 'langages',
    Input::TABLE => 'entrées',
    Permission::TABLE => 'permissions',
    Role::TABLE => 'rôles',
    Site::VIRTUAL_TABLE => 'sites web',
    SitePage::TABLE => 'pages',
    Template::TABLE => 'modèles',
    TemplateTab::TABLE => 'onglets',
    User::TABLE => 'utilisateurs',
    UserBookmark::TABLE => 'signets',
    UserConfiguration::TABLE => 'paramètres',
    ValidationRule::TABLE => 'règles de validation',
];
