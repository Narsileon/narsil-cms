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
        'auth',
        'locales',
        'passwords',
        'tooltips',
        'ui',
        'validation',
    ],
];
