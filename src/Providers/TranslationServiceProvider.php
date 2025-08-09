<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TranslationServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        $this->bootTranslations();
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->app->singleton(LabelsBag::class, function ()
        {
            return new LabelsBag();
        });
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function bootTranslations(): void
    {
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../lang', 'narsil-cms');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'narsil-cms');
    }

    #endregion
}
