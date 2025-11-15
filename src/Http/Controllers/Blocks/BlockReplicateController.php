<?php

namespace Narsil\Http\Controllers\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Elements\Block;
use Narsil\Services\BlockService;

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
        $this->authorize(PermissionEnum::CREATE, Block::class);

        BlockService::replicateBlock($block);

        return back()
            ->with('success', trans('narsil::toasts.success.blocks.replicated'));
    }

    #endregion
}
