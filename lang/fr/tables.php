<?php

#region USE

use Narsil\Cms\Enums\DiskEnum;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Configuration;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Forms\Fieldset;
use Narsil\Cms\Models\Forms\Form;
use Narsil\Cms\Models\Forms\FormStep;
use Narsil\Cms\Models\Forms\FormWebhook;
use Narsil\Cms\Models\Forms\Input;
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
use Narsil\Cms\Models\Users\UserConfiguration;
use Narsil\Cms\Models\ValidationRule;

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
    Media::TABLE => 'médias',
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

    DiskEnum::DOCUMENTS->value => 'documents',
    DiskEnum::IMAGES->value => 'images',
    DiskEnum::VIDEOS->value => 'vidéos',
];
