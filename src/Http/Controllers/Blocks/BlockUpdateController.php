<?php

namespace Narsil\Http\Controllers\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\BlockFormRequest;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Elements\Block;
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
     * @param Request $request
     * @param Block $block
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Block $block): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $block);

        $data = $request->all();

        $rules = app(BlockFormRequest::class)
            ->rules($block);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $block->update($attributes);

        if ($elements = Arr::get($attributes, Block::RELATION_ELEMENTS))
        {
            BlockService::syncBlockElements($block, $elements);
        }

        return $this
            ->redirect(route('blocks.index'), $block)
            ->with('success', ModelService::getSuccessToast(Block::class, EventEnum::UPDATED));
    }

    #endregion
}
