<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Base\Support\TranslationsBag;

#endregion

/**
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
