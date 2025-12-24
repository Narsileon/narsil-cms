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
use Narsil\Models\Globals\FooterSocialLink;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;
use Narsil\Models\Users\UserConfiguration;

#endregion

return [
    Block::TABLE => 'Blocks',
    Configuration::TABLE => 'Einstellungen',
    Entity::TABLE => 'Entitäten',
    Field::TABLE => 'Felder',
    FieldRule::TABLE => 'Regeln',
    Footer::TABLE => 'Fußzeilen',
    FooterSocialLink::TABLE => 'Sozialen Netzwerke',
    Form::TABLE => 'Formulare',
    FormFieldset::TABLE => 'Feldgruppen',
    FormInput::TABLE => 'Eingaben',
    FormInputRule::TABLE => 'Regeln',
    Header::TABLE => 'Kopfzeilen',
    Host::TABLE => 'Hosts',
    HostLocale::TABLE => 'Locales',
    Permission::TABLE => 'Berechtigungen',
    Role::TABLE => 'Rollen',
    Site::VIRTUAL_TABLE => 'Webseiten',
    SitePage::TABLE => 'Seiten von Webseiten',
    Template::TABLE => 'Vorlagen',
    User::TABLE => 'Benutzer',
    UserBookmark::TABLE => 'Lesezeichen',
    UserConfiguration::TABLE => 'Einstellungen',
];
