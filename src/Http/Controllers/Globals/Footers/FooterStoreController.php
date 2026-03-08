<?php

namespace Narsil\Cms\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Actions\Footers\SyncFooterLinks;
use Narsil\Cms\Contracts\Actions\Footers\SyncFooterSocialMedia;
use Narsil\Cms\Contracts\Requests\FooterFormRequest;
use Narsil\Cms\Models\Globals\Footer;

#endregion

/**
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

        app(SyncFooterLinks::class)
            ->run($footer, Arr::get($attributes, Footer::RELATION_LINKS, []));

        app(SyncFooterSocialMedia::class)
            ->run($footer, Arr::get($attributes, Footer::RELATION_SOCIAL_MEDIA, []));

        return $this
            ->redirect(route('footers.index'))
            ->with('success', ModelService::getSuccessMessage(Footer::TABLE, ModelEventEnum::CREATED));
    }

    #endregion
}
