<?php

namespace Narsil\Http\Controllers\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Elements\Block;
use Narsil\Services\ModelService;

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
        $this->authorize(PermissionEnum::DELETE, $block);

        $block->delete();

        return $this
            ->redirect(route('blocks.index'))
            ->with('success', ModelService::getSuccessMessage(Block::class, ModelEventEnum::DELETED));
    }

    #endregion
}
