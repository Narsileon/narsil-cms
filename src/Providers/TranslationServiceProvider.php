<?php

declare(strict_types=1);

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Base\Support\TranslationsBag;

#endregion

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
