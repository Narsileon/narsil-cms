<?php

namespace Narsil\Cms\Contracts\Actions\Elements;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Collections\Element;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface SyncElementConditions extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Element $element
     * @param array $conditions
     *
     * @return Element
     */
    public function run(Element $element, array $conditions): Element;

    #endregion
}
