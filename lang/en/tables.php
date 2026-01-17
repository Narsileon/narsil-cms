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
    Block::TABLE => 'blocks',
    Configuration::TABLE => 'settings',
    Entity::TABLE => 'entities',
    Field::TABLE => 'fields',
    Fieldset::TABLE => 'fieldsets',
    Footer::TABLE => 'footers',
    FooterLink::TABLE => 'links',
    FooterSocialMedium::TABLE => 'social media',
    Form::TABLE => 'forms',
    FormStep::TABLE => 'tabs',
    FormWebhook::TABLE => 'webhooks',
    Header::TABLE => 'headers',
    Host::TABLE => 'hosts',
    HostLocale::TABLE => 'locales',
    HostLocaleLanguage::TABLE => 'languages',
    Input::TABLE => 'inputs',
    Permission::TABLE => 'permissions',
    Role::TABLE => 'roles',
    Site::VIRTUAL_TABLE => 'websites',
    SitePage::TABLE => 'pages',
    Template::TABLE => 'templates',
    TemplateTab::TABLE => 'tabs',
    User::TABLE => 'users',
    UserBookmark::TABLE => 'bookmarks',
    UserConfiguration::TABLE => 'settings',
    ValidationRule::TABLE => 'validation rules',
];
