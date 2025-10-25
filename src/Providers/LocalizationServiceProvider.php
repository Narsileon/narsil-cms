<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LocalizationServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootPublishes();
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
     * Boot the publishes.
     *
     * @return void
     */
    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../../lang' => lang_path('vendor/narsil-cms'),
        ], 'narsil-cms-localization');
    }

    /**
     * Boot the translations.
     *
     * @return void
     */
    protected function bootTranslations(): void
    {
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../lang', 'narsil');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'narsil');
    }

    #endregion
}
