<?php

namespace Narsil\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Contracts\FormRequests\FooterFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Globals\Footer;
use Narsil\Services\Models\FooterService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param FooterFormRequest $request
     * @param Footer $footer
     *
     * @return RedirectResponse
     */
    public function __invoke(FooterFormRequest $request, Footer $footer): RedirectResponse
    {
        $attributes = $request->validated();

        $footer->update($attributes);

        FooterService::syncLinks($footer, Arr::get($attributes, Footer::RELATION_LINKS, []));
        FooterService::syncSocialMedia($footer, Arr::get($attributes, Footer::RELATION_SOCIAL_MEDIA, []));

        return $this
            ->redirect(route('footers.index'))
            ->with('success', ModelService::getSuccessMessage(Footer::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
