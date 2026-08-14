<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Hooks\Footers;

#region USE

use Illuminate\Support\Arr;
use Narsil\Base\Contracts\ModelHook;
use Narsil\Base\Http\Data\ModelHookContext;
use Narsil\Cms\Contracts\Actions\Footers\SyncFooterSocialMedia;
use Narsil\Cms\Models\Globals\Footer;

#endregion

final class SyncFooterSocialMediaHook implements ModelHook
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function handle(ModelHookContext $context): void
    {
        if ($context->model instanceof Footer)
        {
            app(SyncFooterSocialMedia::class)
                ->run($context->model, Arr::get($context->attributes, Footer::RELATION_SOCIAL_MEDIA, []));
        }
    }

    #endregion
}
