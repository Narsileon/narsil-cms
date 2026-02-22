<?php

namespace Narsil\Cms\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Requests\FooterFormRequest;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Services\FooterService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param FooterFormRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(FooterFormRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $footer = Footer::create($attributes);

        FooterService::syncLinks($footer, Arr::get($attributes, Footer::RELATION_LINKS, []));
        FooterService::syncSocialMedia($footer, Arr::get($attributes, Footer::RELATION_SOCIAL_MEDIA, []));

        return $this
            ->redirect(route('footers.index'))
            ->with('success', ModelService::getSuccessMessage(Footer::TABLE, ModelEventEnum::CREATED));
    }

    #endregion
}
