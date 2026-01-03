<?php

namespace Narsil\Http\Controllers\Sites;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Enums\ModelEventEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Implementations\Requests\SiteFormRequest;
use Narsil\Jobs\SitemapJob;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param SiteFormRequest $request
     * @param Site $site
     *
     * @return RedirectResponse
     */
    public function __invoke(SiteFormRequest $request, Site $site): RedirectResponse
    {
        $attributes = $request->validated();

        $site->update($attributes);

        $tree = Arr::get($attributes, Site::RELATION_PAGES, []);

        SitePage::rebuildTree($tree);

        SitemapJob::dispatch($site);

        return back()
            ->with('success', ModelService::getSuccessMessage(Site::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
