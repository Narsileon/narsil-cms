<?php

namespace Narsil\Cms\Http\Controllers\Collections\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\ReplicateManyRequest;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Services\BlockService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockReplicateManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(AbilityEnum::CREATE, Block::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $blocks = Block::query()
            ->findMany($ids);

        foreach ($blocks as $block)
        {
            BlockService::replicate($block);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Block::TABLE, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
