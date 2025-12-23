<?php

namespace Narsil\Http\Controllers\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Elements\Block;
use Narsil\Services\Models\BlockService;
use Narsil\Services\ModelService;

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
        $this->authorize(PermissionEnum::CREATE, Block::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $blocks = Block::query()
            ->findMany($ids);

        foreach ($blocks as $block)
        {
            BlockService::replicateBlock($block);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Block::class, EventEnum::REPLICATED_MANY));
    }

    #endregion
}
