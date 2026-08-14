<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Hooks\Templates;

#region USE

use Illuminate\Support\Arr;
use Narsil\Base\Contracts\ModelHook;
use Narsil\Base\Http\Data\ModelHookContext;
use Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabs;
use Narsil\Cms\Models\Collections\Template;

#endregion

final class SyncTemplateTabsHook implements ModelHook
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function handle(ModelHookContext $context): void
    {
        if ($context->model instanceof Template)
        {
            app(SyncTemplateTabs::class)
                ->run($context->model, Arr::get($context->attributes, Template::RELATION_TABS, []));
        }
    }

    #endregion
}
