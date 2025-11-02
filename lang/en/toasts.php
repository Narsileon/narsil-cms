<?php

#region USE

use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostPage;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;

#endregion

return [
    'success' => [
        'logged_in'  => 'You have been successfully logged in.',
        'logged_out' => 'You have been successfully logged out.',
        'password'   => [
            'confirmed' => 'Your password has been successfully confirmed.',
            'updated'   => 'Your password has been successfully updated.',
        ],
        'profile' => [
            'updated' => 'Your profile has been successfully updated.'
        ],
        'sessions' => [
            'deleted_all'     => 'You have been logged out from all devices.',
            'deleted_current' => 'You have been logged out from this device.',
            'deleted_others'  => 'You have been logged out from other devices.',
        ],
        'sites' => [
            'updated' => 'The site has been successfully updated.',
        ],
        'two_factor' => [
            'confirmed' => 'Your two factor authentication has been successfully confirmed.',
            'disabled'  => 'Your two factor authentication has been successfully disabled.',
        ],

        // Models
        Block::TABLE => [
            'created' => 'The block has been successfully created.',
            'deleted' => 'The block has been successfully deleted.',
            'deleted_many' => 'The blocks have been successfully deleted.',
            'replicated' => 'The block has been successfully duplicated.',
            'replicated_many' => 'The blocks have been successfully duplicated.',
            'updated' => 'The block has been successfully updated.',
        ],
        Entity::TABLE => [
            'created' => 'The entity has been successfully created.',
            'deleted' => 'The entity has been successfully deleted.',
            'deleted_many' => 'The entities have been successfully deleted.',
            'replicated' => 'The entity has been successfully duplicated.',
            'replicated_many' => 'The entities have been successfully duplicated.',
            'updated' => 'The entity has been successfully updated.',
        ],
        Field::TABLE => [
            'created' => 'The field has been successfully created.',
            'deleted' => 'The field has been successfully deleted.',
            'deleted_many' => 'The fields have been successfully deleted.',
            'replicated' => 'The field has been successfully duplicated.',
            'replicated_many' => 'The fields have been successfully duplicated.',
            'updated' => 'The field has been successfully updated.',
        ],
        Host::TABLE => [
            'created' => 'The host has been successfully created.',
            'deleted' => 'The host has been successfully deleted.',
            'deleted_many' => 'The hosts have been successfully deleted.',
            'replicated' => 'The host has been successfully duplicated.',
            'replicated_many' => 'The hosts have been successfully duplicated.',
            'updated' => 'The host has been successfully updated.',
        ],
        HostPage::TABLE => [
            'created' => 'The page has been successfully created.',
            'deleted' => 'The page has been successfully deleted.',
            'updated' => 'The page has been successfully updated.',
        ],
        Role::TABLE => [
            'created' => 'The role has been successfully created.',
            'deleted' => 'The role has been successfully deleted.',
            'deleted_many' => 'The roles have been successfully deleted.',
            'replicated' => 'The role has been successfully duplicated.',
            'replicated_many' => 'The roles have been successfully duplicated.',
            'updated' => 'The role has been successfully updated.',
        ],
        Template::TABLE => [
            'created' => 'The template has been successfully created.',
            'deleted' => 'The template has been successfully deleted.',
            'deleted_many' => 'The templates have been successfully deleted.',
            'replicated' => 'The template has been successfully duplicated.',
            'replicated_many' => 'The templates have been successfully duplicated.',
            'updated' => 'The template has been successfully updated.',
        ],
        User::TABLE => [
            'created' => 'The user has been successfully created.',
            'deleted' => 'The user has been successfully deleted.',
            'deleted_many' => 'The users have been successfully deleted.',
            'updated' => 'The user has been successfully updated.',
        ],
    ],
];
