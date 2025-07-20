<?php

#region USE

use App\Providers\AppServiceProvider;
use App\Providers\ComponentServiceProvider;
use App\Providers\FieldSettingsServiceProvider;
use App\Providers\FormRequestServiceProvider;
use App\Providers\FormServiceProvider;
use App\Providers\FortifyServiceProvider;

#endregion

return [
    AppServiceProvider::class,
    ComponentServiceProvider::class,
    FieldSettingsServiceProvider::class,
    FormServiceProvider::class,
    FormRequestServiceProvider::class,
    FortifyServiceProvider::class,
];
