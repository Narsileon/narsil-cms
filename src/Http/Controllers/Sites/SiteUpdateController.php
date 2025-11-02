<?php

namespace Narsil\Http\Controllers\Sites;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\SiteFormRequest;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostPage;

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
        $data = $request->all();

        $rules = app(SiteFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $tree = $attributes[Host::RELATION_PAGES];

        HostPage::rebuildTree($tree);

        return back()
            ->with('success', trans('narsil::toasts.success.sites.updated'));
    }

    #endregion
}
