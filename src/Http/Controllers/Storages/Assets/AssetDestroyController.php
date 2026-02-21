<?php

namespace Narsil\Cms\Http\Controllers\Storages\Assets;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Storages\Asset;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AssetDestroyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Asset $asset
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Asset $asset): RedirectResponse
    {
        $this->authorize(AbilityEnum::DELETE, $asset);

        $asset->delete();

        return $this
            ->redirect(route('assets.index'))
            ->with('success', ModelService::getSuccessMessage(Asset::TABLE, ModelEventEnum::DELETED));
    }

    #endregion
}
