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

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockDestroyController extends RedirectController
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
        $this->authorize(AbilityEnum::DELETE, $block);

        $block->delete();

        return $this
            ->redirect(route('blocks.index'))
            ->with('success', ModelService::getSuccessMessage(Block::TABLE, ModelEventEnum::DELETED));
    }

    #endregion
}
