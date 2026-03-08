<?php

namespace Narsil\Cms\Http\Controllers\Collections\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Actions\Blocks\ReplicateBlock;
use Narsil\Cms\Models\Collections\Block;

#endregion

/**
 * @author Jonathan Rigaux
 */
class BlockReplicateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Block $block
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Block $block): RedirectResponse
    {
        $this->authorize(AbilityEnum::CREATE, Block::class);

        app(ReplicateBlock::class)
            ->run($block);

        return back()
            ->with('success', ModelService::getSuccessMessage(Block::TABLE, ModelEventEnum::REPLICATED));
    }

    #endregion
}
