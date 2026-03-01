<?php

namespace Narsil\Cms\Http\Controllers\Sites;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Implementations\Requests\SiteFormRequest;
use Narsil\Cms\Jobs\SitemapJob;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteUpdateController extends RedirectController
{
    use HasSchemas;

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

        SitemapJob::dispatch($site, $this->getCurrentSchema());

        return back()
            ->with('success', ModelService::getSuccessMessage(Site::TABLE, ModelEventEnum::UPDATED));
    }

    #endregion
}
