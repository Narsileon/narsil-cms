<?php

namespace Narsil\Http\Controllers\Sites;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\SiteFormRequest;
use Narsil\Jobs\SitemapJob;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteUpdateController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $site
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, string $site): RedirectResponse
    {
        $site = Site::query()
            ->where(Site::HANDLE, $site)
            ->first();

        if (!$site)
        {
            abort(404);
        }

        $this->authorize(PermissionEnum::UPDATE, $site);

        $data = $request->all();

        $rules = app(SiteFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $site->update($attributes);

        $tree = $attributes[Site::RELATION_PAGES];

        SitePage::rebuildTree($tree);

        SitemapJob::dispatch();

        return back()
            ->with('success', trans('narsil::toasts.success.sites.updated'));
    }

    #endregion
}
