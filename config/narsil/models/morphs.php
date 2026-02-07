<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model Morphs
    |--------------------------------------------------------------------------
    |
    | Mapping between model classes and their morphs.
    |
    */

    \Narsil\Cms\Models\Collections\Block::class => \Narsil\Cms\Models\Collections\Block::TABLE,
    \Narsil\Cms\Models\Collections\BlockElement::class => \Narsil\Cms\Models\Collections\BlockElement::TABLE,
    \Narsil\Cms\Models\Collections\Field::class => \Narsil\Cms\Models\Collections\Field::TABLE,
    \Narsil\Cms\Models\Collections\TemplateTab::class => \Narsil\Cms\Models\Collections\TemplateTab::TABLE,
    \Narsil\Cms\Models\Collections\TemplateTabElement::class => \Narsil\Cms\Models\Collections\TemplateTabElement::TABLE,
    \Narsil\Cms\Models\Entities\Entity::class => \Narsil\Cms\Models\Entities\Entity::TABLE,
    \Narsil\Cms\Models\Globals\Footer::class => \Narsil\Cms\Models\Globals\Footer::TABLE,
    \Narsil\Cms\Models\Globals\Header::class => \Narsil\Cms\Models\Globals\Header::TABLE,
    \Narsil\Cms\Models\Hosts\Host::class => \Narsil\Cms\Models\Hosts\Host::TABLE,
    \Narsil\Cms\Models\Hosts\HostLocale::class => \Narsil\Cms\Models\Hosts\HostLocale::TABLE,
    \Narsil\Cms\Models\Hosts\HostLocaleLanguage::class => \Narsil\Cms\Models\Hosts\HostLocaleLanguage::TABLE,
    \Narsil\Cms\Models\Policies\Permission::class => \Narsil\Cms\Models\Policies\Permission::TABLE,
    \Narsil\Cms\Models\Policies\Role::class => \Narsil\Cms\Models\Policies\Role::TABLE,
    \Narsil\Cms\Models\Sites\SitePage::class => \Narsil\Cms\Models\Sites\SitePage::TABLE,
    \Narsil\Cms\Models\Storages\Media::class => \Narsil\Cms\Models\Storages\Media::TABLE,
    \Narsil\Cms\Models\User::class => \Narsil\Cms\Models\User::TABLE,
];
