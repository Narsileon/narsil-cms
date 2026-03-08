<?php

namespace Narsil\Cms\Implementations\Actions\Blocks;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Base\Services\DatabaseService;
use Narsil\Cms\Contracts\Actions\Blocks\ReplicateBlock as Contract;
use Narsil\Cms\Contracts\Actions\Blocks\SyncBlockElements;
use Narsil\Cms\Models\Collections\Block;

#endregion

/**
 * @author Jonathan Rigaux
 */
class ReplicateBlock extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Block $block): Block
    {
        $replicated = $block->replicate();

        $replicated
            ->fill([
                Block::HANDLE => DatabaseService::generateUniqueValue($replicated, Block::HANDLE, $block->{Block::HANDLE}),
            ])
            ->save();

        $elements = $block->elements()->get()->toArray();

        app(SyncBlockElements::class)
            ->run($replicated, $elements);

        return $replicated;
    }

    #endregion
}
