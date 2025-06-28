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
        'colors',
        'locales',
        'pagination',
        'passwords',
        'placeholders',
        'sr',
        'themes',
        'tooltips',
        'ui',
        'validation',
    ],
];
