<?php

namespace Narsil\Http\Controllers\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Elements\Block;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Block::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Block::query()
            ->whereIn(Block::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('blocks.index'))
            ->with('success', ModelService::getSuccessMessage(Block::class, ModelEventEnum::DELETED_MANY));
    }

    #endregion
}
