<?php

namespace Narsil\Cms\Http\Controllers\Collections\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Actions\Blocks\SyncBlockElements;
use Narsil\Cms\Contracts\Requests\BlockFormRequest;
use Narsil\Cms\Models\Collections\Block;

#endregion

/**
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

        app(SyncBlockElements::class)
            ->run($block, Arr::get($attributes, Block::RELATION_ELEMENTS, []));

        return $this
            ->redirect(route('blocks.index'), $block)
            ->with('success', ModelService::getSuccessMessage(Block::TABLE, ModelEventEnum::CREATED));
    }

    #endregion
}
