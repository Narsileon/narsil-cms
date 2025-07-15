<?php

namespace App\Providers;

#region USE

use App\Support\LabelsBag;
use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AppServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->app->singleton(LabelsBag::class, function ()
        {
            return new LabelsBag();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(): void
    {
        //
    }

    #endregion
}
