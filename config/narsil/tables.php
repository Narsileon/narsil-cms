<?php

#region USE

use App\Models\Sites\Site;

#endregion

return [
    Site::TABLE => [
        Site::NAME,
        Site::HANDLE,
        Site::LANGUAGE,
        Site::PRIMARY,
    ],
];
