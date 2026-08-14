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
interface CreateEntityBlockNode extends Action
{
    #region PUBLIC METHODS

    /**
     * @param EntityNode $parent
     * @param integer $blockId
     * @param integer|null $position
     *
     * @return EntityNode
     */
    public function run(EntityNode $parent, int $blockId, ?int $position = null): EntityNode;

    #endregion
}
