<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Ui\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class TranslationServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

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
}
