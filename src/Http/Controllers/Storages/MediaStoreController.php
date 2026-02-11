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
