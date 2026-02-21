<?php

namespace Narsil\Cms\Http\Controllers\Collections\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Services\Models\BlockService;

#endregion

/**
 * @version 1.0.0
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

        BlockService::replicate($block);

        return back()
            ->with('success', ModelService::getSuccessMessage(Block::TABLE, ModelEventEnum::REPLICATED));
    }

    #endregion
}
