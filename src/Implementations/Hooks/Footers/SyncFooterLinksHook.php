<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Hooks\Footers;

#region USE

use Illuminate\Support\Arr;
use Narsil\Base\Contracts\ModelHook;
use Narsil\Base\Http\Data\ModelHookContext;
use Narsil\Cms\Contracts\Actions\Footers\SyncFooterLinks;
use Narsil\Cms\Models\Globals\Footer;

#endregion

final class SyncFooterLinksHook implements ModelHook
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function handle(ModelHookContext $context): void
    {
        if ($context->model instanceof Footer)
        {
            app(SyncFooterLinks::class)
                ->run($context->model, Arr::get($context->attributes, Footer::RELATION_LINKS, []));
        }
    }

    #endregion
}
