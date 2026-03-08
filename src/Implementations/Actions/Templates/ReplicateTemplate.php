<?php

namespace Narsil\Cms\Implementations\Actions\Templates;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Base\Services\DatabaseService;
use Narsil\Cms\Contracts\Actions\Templates\ReplicateTemplate as Contract;
use Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabs;
use Narsil\Cms\Models\Collections\Template;

#endregion

/**
 * @author Jonathan Rigaux
 */
class ReplicateTemplate extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Template $template): Template
    {
        $replicated = $template->replicate();

        $replicated
            ->fill([
                Template::TABLE_NAME => DatabaseService::generateUniqueValue($replicated, Template::TABLE_NAME, $template->{Template::TABLE_NAME}),
            ])
            ->save();

        $templateTabs = $template->tabs()->get()->toArray();

        app(SyncTemplateTabs::class)
            ->run($replicated, $templateTabs);

        return $replicated;
    }

    #endregion
}
