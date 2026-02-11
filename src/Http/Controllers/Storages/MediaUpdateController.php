<?php

namespace Narsil\Cms\Http\Controllers\Storages;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Contracts\Requests\MediaFormRequest;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Storages\Media;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MediaUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param MediaFormRequest $request
     * @param string $disk
     * @param Media $media
     *
     * @return RedirectResponse
     */
    public function __invoke(MediaFormRequest $request, string $disk, Media $media): RedirectResponse
    {
        $attributes = $request->validated();

        $media->update($attributes);

        return $this
            ->redirect(route('media.index', [
                'disk' => $disk,
            ]))
            ->with('success', ModelService::getSuccessMessage(Media::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
