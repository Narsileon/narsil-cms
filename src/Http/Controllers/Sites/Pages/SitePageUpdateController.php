<?php

namespace Narsil\Cms\Http\Controllers\Sites\Pages;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Requests\SitePageFormRequest;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Services\SitePageService;

#endregion

/**
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

        SitePageService::syncEntities($sitePage, Arr::get($attributes, SitePage::RELATION_ENTITIES, []));

        return redirect(route('sites.edit', $site))
            ->with('success', ModelService::getSuccessMessage(SitePage::TABLE, ModelEventEnum::UPDATED));
    }

    #endregion
}
