<?php

namespace Narsil\Cms\Http\Controllers\Storages\Assets;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Contracts\Requests\AssetFormRequest;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Storages\Asset;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AssetUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param AssetFormRequest $request
     * @param Asset $asset
     *
     * @return RedirectResponse
     */
    public function __invoke(AssetFormRequest $request, Asset $asset): RedirectResponse
    {
        $attributes = $request->validated();

        $asset->update($attributes);

        return $this
            ->redirect(route('assets.index'))
            ->with('success', ModelService::getSuccessMessage(Asset::TABLE, ModelEventEnum::UPDATED));
    }

    #endregion
}
