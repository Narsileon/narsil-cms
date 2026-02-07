<?php

#region USE

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
use Narsil\Cms\Models\Users\UserConfiguration;
use Narsil\Cms\Models\ValidationRule;

#endregion

return [
    Block::TABLE => 'blocks',
    Configuration::TABLE => 'settings',
    Entity::TABLE => 'entities',
    Field::TABLE => 'fields',
    Footer::TABLE => 'footers',
    FooterLink::TABLE => 'links',
    FooterSocialMedium::TABLE => 'social media',
    Header::TABLE => 'headers',
    Host::TABLE => 'hosts',
    HostLocale::TABLE => 'locales',
    HostLocaleLanguage::TABLE => 'languages',
    Media::TABLE => 'media',
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

    DiskEnum::DOCUMENTS->value => 'documents',
    DiskEnum::IMAGES->value => 'images',
    DiskEnum::VIDEOS->value => 'videos',
];
