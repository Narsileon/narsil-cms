<?php

namespace Narsil\Cms\Contracts\Actions\LiveEditor;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Entities\EntityNode;

#endregion

/**
 * @author Jonathan Rigaux
 *
 * @see vendor/narsil/cms/config/bindings/actions.php
 */
interface DeleteEntityNode extends Action
{
    #region PUBLIC METHODS

    /**
     * @param EntityNode $node
     *
     * @return void
     */
    public function run(EntityNode $node): void;

    #endregion
}
