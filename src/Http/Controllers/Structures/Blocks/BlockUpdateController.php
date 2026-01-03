<?php

namespace Narsil\Http\Controllers\Structures\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Contracts\FormRequests\BlockFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Structures\Block;
use Narsil\Services\Models\BlockService;
use Narsil\Services\ModelService;

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
            ->with('success', ModelService::getSuccessMessage(Block::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
