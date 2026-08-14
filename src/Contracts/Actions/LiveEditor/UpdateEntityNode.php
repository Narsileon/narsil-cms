<?php

declare(strict_types=1);

namespace Narsil\Cms\Contracts\Actions\LiveEditor;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Entities\EntityNode;

#endregion

/**
 * @author Jonathan Rigaux
 *
 * @see vendor/narsil/cms/src/ServiceProvider.php
 */
interface UpdateEntityNode extends Action
{
    #region PUBLIC METHODS

    /**
     * @param EntityNode $node
     * @param array $attributes
     *
     * @return EntityNode
     */
    public function run(EntityNode $node, array $attributes): EntityNode;

    #endregion
}
