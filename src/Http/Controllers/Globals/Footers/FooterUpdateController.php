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

        app(SyncFooterLinks::class)
            ->run($footer, Arr::get($attributes, Footer::RELATION_LINKS, []));

        app(SyncFooterSocialMedia::class)
            ->run($footer, Arr::get($attributes, Footer::RELATION_SOCIAL_MEDIA, []));

        return $this
            ->redirect(route('footers.index'))
            ->with('success', ModelService::getSuccessMessage(Footer::TABLE, ModelEventEnum::UPDATED));
    }

    #endregion
}
