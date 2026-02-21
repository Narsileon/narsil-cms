<?php

namespace Narsil\Cms\Http\Controllers\Collections\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Requests\BlockFormRequest;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Services\Models\BlockService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param BlockFormRequest $request
     * @param Block $block
     *
     * @return RedirectResponse
     */
    public function __invoke(BlockFormRequest $request, Block $block): RedirectResponse
    {
        $attributes = $request->validated();

        $block->update($attributes);

        BlockService::syncBlockElements($block, Arr::get($attributes, Block::RELATION_ELEMENTS, []));

        return $this
            ->redirect(route('blocks.index'), $block)
            ->with('success', ModelService::getSuccessMessage(Block::TABLE, ModelEventEnum::UPDATED));
    }

    #endregion
}
