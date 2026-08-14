<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Hooks\Hosts;

#region USE

use Illuminate\Support\Arr;
use Narsil\Base\Contracts\ModelHook;
use Narsil\Base\Http\Data\ModelHookContext;
use Narsil\Cms\Contracts\Actions\Hosts\SyncHostLocales;
use Narsil\Cms\Models\Hosts\Host;

#endregion

final class SyncHostLocalesHook implements ModelHook
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function handle(ModelHookContext $context): void
    {
        if ($context->model instanceof Host)
        {
            app(SyncHostLocales::class)
                ->run($context->model, [
                    Arr::get($context->attributes, Host::RELATION_DEFAULT_LOCALE, []),
                    ...Arr::get($context->attributes, Host::RELATION_OTHER_LOCALES, []),
                ]);
        }
    }

    #endregion
}
