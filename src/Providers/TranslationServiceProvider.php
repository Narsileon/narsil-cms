<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
        $this->app->singleton(TranslationsBag::class, function ()
        {
            return new TranslationsBag();
        });
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function bootTranslations(): void
    {
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../lang', 'narsil');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'narsil');
    }

    #endregion
}
