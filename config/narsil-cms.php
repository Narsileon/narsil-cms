<?php

#region USE

use App\Models\Sites\Site;

#endregion

return [
    'locales' => [
        'de',
        'en',
        'fr',
    ],
    'tables' => [
        Site::TABLE => [
            Site::NAME,
            Site::HANDLE,
            Site::LANGUAGE,
            Site::PRIMARY,
        ],
    ],
    'translations' => [
        'accessibility',
        'auth',
        'colors',
        'email',
        'locales',
        'pagination',
        'passwords',
        'placeholders',
        'sessions',
        'themes',
        'two-factor',
        'ui',
        'validation',
    ],
];
