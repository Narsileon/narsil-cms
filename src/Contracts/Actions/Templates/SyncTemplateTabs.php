<?php

namespace Narsil\Cms\Contracts\Actions\Templates;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Collections\Template;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface SyncTemplateTabs extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Template $template
     * @param array $tabs
     *
     * @return Template
     */
    public function run(Template $template, array $tabs): Template;

    #endregion
}
