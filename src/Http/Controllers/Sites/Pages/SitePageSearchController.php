<?php

namespace Narsil\Http\Controllers\Sites\Pages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Sites\SitePage;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageSearchController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $search
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request, string $search): JsonResponse
    {
        $selectOptions = SitePage::query()
            ->when($search, function ($query) use ($search)
            {
                return $query
                    ->where(SitePage::SLUG, 'like', "%$search%");
            })
            ->get()
            ->map(function (SitePage $sitePage)
            {
                return (new SelectOption())
                    ->optionLabel($sitePage->{SitePage::SLUG})
                    ->optionValue($sitePage->{SitePage::ID});
            })
            ->all();

        return redirect()
            ->json($selectOptions);
    }

    #endregion
}
