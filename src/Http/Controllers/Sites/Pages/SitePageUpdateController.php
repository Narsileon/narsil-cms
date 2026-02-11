<?php

namespace Narsil\Cms\Http\Controllers\Sites\Pages;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Contracts\Requests\SitePageFormRequest;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param SitePageFormRequest $request
     * @param string $site
     * @param SitePage $sitePage
     *
     * @return RedirectResponse
     */
    public function __invoke(SitePageFormRequest $request, string $site, SitePage $sitePage): RedirectResponse
    {
        $attributes = $request->validated();

        $sitePage->update($attributes);

        return redirect(route('sites.edit', $site))
            ->with('success', ModelService::getSuccessMessage(SitePage::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
