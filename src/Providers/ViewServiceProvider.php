<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class ViewServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootViews();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the views.
     *
     * @return void
     */
    protected function bootViews(): void
    {
        $this->loadViewsFrom([
            __DIR__ . '/../../resources/views',
        ], 'narsil');
    }

    #endregion
}
