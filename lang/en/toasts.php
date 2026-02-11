<?php

#region USE

use Narsil\Base\Enums\ModelEventEnum;

#endregion

return [
    'success' => [
        ModelEventEnum::CREATED->value => 'The :model has been successfully created.',
        ModelEventEnum::DELETED_MANY->value => 'The :table have been successfully deleted.',
        ModelEventEnum::DELETED->value => 'The :model has been successfully deleted.',
        ModelEventEnum::REPLICATED_MANY->value => 'The :table have been successfully duplicated.',
        ModelEventEnum::REPLICATED->value => 'The :model has been successfully duplicated.',
        ModelEventEnum::RESTORED->value => 'The :model has been successfully restored.',
        ModelEventEnum::UPDATED->value => 'The :model has been successfully updated.',

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
