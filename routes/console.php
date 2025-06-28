<?php

#region USE

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

#endregion

Artisan::command('inspire', function ()
{
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
