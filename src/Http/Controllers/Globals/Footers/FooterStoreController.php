<?php

namespace Narsil\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\FooterFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Globals\Footer;
use Narsil\Services\Models\FooterService;
use Narsil\Services\ModelService;

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
            ->with('success', ModelService::getSuccessMessage(Footer::class, ModelEventEnum::CREATED));
    }

    #endregion
}
