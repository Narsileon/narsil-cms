<?php

namespace Narsil\Http\Controllers\Sites\Pages;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Contracts\FormRequests\SitePageFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Sites\SitePage;
use Narsil\Services\ModelService;

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
