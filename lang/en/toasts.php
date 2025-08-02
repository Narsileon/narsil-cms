<?php

#region USE

use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteGroup;
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
        'two_factor' => [
            'confirmed' => 'Your two factor authentication has been successfully confirmed.',
            'disabled'  => 'Your two factor authentication has been successfully disabled.',
        ],

        // Models

        Block::TABLE => [
            'created' => 'The block has been successfully created.',
            'deleted' => 'The block has been successfully deleted.',
            'updated' => 'The block has been successfully updated.',
        ],
        Field::TABLE => [
            'created' => 'The field has been successfully created.',
            'deleted' => 'The field has been successfully deleted.',
            'updated' => 'The field has been successfully updated.',
        ],
        SiteGroup::TABLE => [
            'created' => 'The group has been successfully created.',
            'deleted' => 'The group has been successfully deleted.',
            'updated' => 'The group has been successfully updated.',
        ],
        Site::TABLE => [
            'created' => 'The site has been successfully created.',
            'deleted' => 'The site has been successfully deleted.',
            'updated' => 'The site has been successfully updated.',
        ],
        Template::TABLE => [
            'created' => 'The template has been successfully created.',
            'deleted' => 'The template has been successfully deleted.',
            'updated' => 'The template has been successfully updated.',
        ],
        User::TABLE => [
            'created' => 'The user has been successfully created.',
            'deleted' => 'The user has been successfully deleted.',
            'updated' => 'The user has been successfully updated.',
        ],
    ],
];
