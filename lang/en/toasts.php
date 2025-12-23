<?php

#region USE

use Narsil\Enums\Database\EventEnum;

#endregion

return [
    'success' => [
        EventEnum::CREATED->value => 'The :model has been successfully created.',
        EventEnum::DELETED_MANY->value => 'The :table have been successfully deleted.',
        EventEnum::DELETED->value => 'The :model has been successfully deleted.',
        EventEnum::REPLICATED_MANY->value => 'The :table have been successfully duplicated.',
        EventEnum::REPLICATED->value => 'The :model has been successfully duplicated.',
        EventEnum::RESTORED->value => 'The :model has been successfully restored.',
        EventEnum::UPDATED->value => 'The :model has been successfully updated.',

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
    ],
];
