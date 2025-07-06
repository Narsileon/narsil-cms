<?php

#region USE

use App\Http\Forms\LoginForm;
use App\Http\Forms\RegisterForm;
use App\Http\Forms\SiteForm;
use App\Http\Forms\SiteGroupForm;
use App\Models\Site;
use App\Models\SiteGroup;

#endregion

return [
    'login' => LoginForm::class,
    'register' => RegisterForm::class,

    Site::TABLE => SiteForm::class,
    SiteGroup::TABLE => SiteGroupForm::class,
];
