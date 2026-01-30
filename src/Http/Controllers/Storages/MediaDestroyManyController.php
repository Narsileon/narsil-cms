<?php

namespace Narsil\Http\Controllers\Storages;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Storages\Media;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MediaDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     * @param string $disk
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request, string $disk): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Media::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Media::query()
            ->whereIn(Media::UUID, $ids)
            ->delete();

        return $this
            ->redirect(route('media.index', [
                'disk' => $disk,
            ]))
            ->with('success', ModelService::getSuccessMessage(Media::class, ModelEventEnum::DELETED_MANY));
    }

    #endregion
}
