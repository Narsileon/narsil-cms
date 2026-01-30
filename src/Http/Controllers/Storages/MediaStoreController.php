<?php

namespace Narsil\Http\Controllers\Storages;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Contracts\FormRequests\MediaFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Storages\Media;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MediaStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param MediaFormRequest $request
     * @param string $disk
     *
     * @return RedirectResponse
     */
    public function __invoke(MediaFormRequest $request, string $disk): RedirectResponse
    {
        $attributes = $request->validated();

        Media::create([
            ...$attributes,
            Media::DISK  => $disk,
        ]);

        return $this
            ->redirect(route('media.index', [
                'disk' => $disk,
            ]))
            ->with('success', ModelService::getSuccessMessage(Media::class, ModelEventEnum::CREATED));
    }

    #endregion
}
