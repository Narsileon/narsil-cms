<?php

namespace Narsil\Cms\Http\Controllers\Storages\Assets;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\DestroyManyRequest;
use Narsil\Cms\Models\Storages\Asset;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AssetDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Asset::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Asset::query()
            ->whereIn(Asset::UUID, $ids)
            ->delete();

        return $this
            ->redirect(route('assets.index'))
            ->with('success', ModelService::getSuccessMessage(Asset::TABLE, ModelEventEnum::DELETED_MANY));
    }

    #endregion
}
