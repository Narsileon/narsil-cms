<?php

namespace Narsil\Http\Controllers\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Elements\Block;
use Narsil\Services\BlockService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockReplicateManyController extends AbstractController
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
            ->with('success', trans('narsil::toasts.success.blocks.replicated_many'));
    }

    #endregion
}
