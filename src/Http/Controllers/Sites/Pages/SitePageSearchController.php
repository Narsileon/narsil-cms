<?php

namespace Narsil\Cms\Http\Controllers\Sites\Pages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Http\Data\OptionData;
use Narsil\Base\Http\Requests\SearchRequest;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageSearchController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param SearchRequest $request
     * @param string $search
     *
     * @return JsonResponse
     */
    public function __invoke(SearchRequest $request): JsonResponse
    {
        $locale = App::getLocale();

        $search = $request->validated(SearchRequest::SEARCH);

        $selectOptions = SitePage::query()
            ->when($search, function ($query) use ($locale, $search)
            {
                return $query
                    ->where(SitePage::SLUG . '->' . $locale, 'like', "%$search%");
            })
            ->get()
            ->map(function (SitePage $sitePage)
            {
                return new OptionData(
                    label: $sitePage->{SitePage::SLUG},
                    value: $sitePage->{SitePage::ID},
                );
            })
            ->all();

        return response()
            ->json($selectOptions);
    }

    #endregion
}
