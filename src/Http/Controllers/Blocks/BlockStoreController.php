<?php

namespace Narsil\Http\Controllers\Blocks;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\BlockFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Elements\Block;
use Narsil\Services\BlockService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockStoreController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Block::class);

        $data = $request->all();

        $rules = app(BlockFormRequest::class)->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $block = Block::create($attributes);

        if ($elements = Arr::get($attributes, Block::RELATION_ELEMENTS))
        {
            BlockService::syncElements($block, $elements);
        }

        return $this
            ->redirect(route('blocks.index'), $block)
            ->with('success', trans('narsil::toasts.success.blocks.created'));
    }

    #endregion
}
