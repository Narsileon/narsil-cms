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
class BlockStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param BlockFormRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(BlockFormRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $block = Block::create($attributes);

        BlockService::syncBlockElements($block, Arr::get($attributes, Block::RELATION_ELEMENTS, []));

        return $this
            ->redirect(route('blocks.index'), $block)
            ->with('success', ModelService::getSuccessMessage(Block::class, ModelEventEnum::CREATED));
    }

    #endregion
}
