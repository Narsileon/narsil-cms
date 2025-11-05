<?php

namespace Narsil\Http\Controllers\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Elements\Block;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockDestroyManyController extends AbstractController
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
            ->with('success', trans('narsil::toasts.success.blocks.deleted_many'));
    }

    #endregion
}
