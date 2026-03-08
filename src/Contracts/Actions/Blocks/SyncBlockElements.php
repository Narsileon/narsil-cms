<?php

namespace Narsil\Cms\Contracts\Actions\Blocks;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Collections\Block;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface SyncBlockElements extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Block $block
     * @param array $elements
     *
     * @return Block
     */
    public function run(Block $block, array $elements): Block;

    #endregion
}
