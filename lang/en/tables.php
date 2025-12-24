<?php

#region USE

use Narsil\Models\Configuration;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldRule;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Models\Forms\FormInput;
use Narsil\Models\Forms\FormInputRule;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;
use Narsil\Models\Users\UserConfiguration;

#endregion

return [
    Block::TABLE => 'blocks',
    Configuration::TABLE => 'settings',
    Entity::TABLE => 'entities',
    Field::TABLE => 'fields',
    FieldRule::TABLE => 'rules',
    Footer::TABLE => 'footers',
    Form::TABLE => 'forms',
    FormFieldset::TABLE => 'fieldsets',
    FormInput::TABLE => 'inputs',
    FormInputRule::TABLE => 'rules',
    Header::TABLE => 'headers',
    Host::TABLE => 'hosts',
    Permission::TABLE => 'permissions',
    Role::TABLE => 'roles',
    Site::VIRTUAL_TABLE => 'websites',
    SitePage::TABLE => 'website pages',
    Template::TABLE => 'templates',
    User::TABLE => 'users',
    UserBookmark::TABLE => 'bookmarks',
    UserConfiguration::TABLE => 'settings',
];
