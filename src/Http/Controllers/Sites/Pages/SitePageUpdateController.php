<?php

namespace Narsil\Http\Controllers\Sites\Pages;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\SitePageFormRequest;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
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
     * @param Request $request
     * @param string $site
     * @param SitePage $sitePage
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, string $site, SitePage $sitePage): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $sitePage);

        $data = $request->all();

        $rules = app(SitePageFormRequest::class)
            ->rules($sitePage);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $sitePage->update($attributes);

        return redirect(route('sites.edit', $site))
            ->with('success', ModelService::getSuccessToast(SitePage::class, EventEnum::UPDATED));
    }

    #endregion
}
