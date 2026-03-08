<?php

namespace Narsil\Cms\Contracts\Actions\Templates;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Collections\TemplateTab;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface SyncTemplateTabElements extends Action
{
    #region PUBLIC METHODS

    /**
     * @param TemplateTab $templateTab
     * @param array $elements
     *
     * @return TemplateTab
     */
    public function run(TemplateTab $templateTab, array $elements): TemplateTab;

    #endregion
}
