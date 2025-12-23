<?php

namespace Narsil\Http\Controllers\Sites\Pages;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
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
class SitePageStoreController extends RedirectController
{
    #region CONSTRUCTORS

    /**
     * @return void
     */
    public function __construct()
    {
        $this->country = Session::get(SitePage::COUNTRY, 'default');
    }

    #endregion

    #region PROPERTIES

    /**
     * The country associated to the request.
     *
     * @var string
     */
    protected readonly string $country;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, string $site): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, SitePage::class);

        $data = $request->all();

        $rules = app(SitePageFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $attributes[SitePage::COUNTRY] = Session::get(SitePage::COUNTRY);

        $lastChild = $this->findLastChild($attributes);

        $sitePage = SitePage::create(array_merge($attributes, [
            SitePage::LEFT_ID => $lastChild?->{SitePage::ID},
        ]));

        if ($lastChild)
        {
            $lastChildAttributes = [
                SitePage::RIGHT_ID => $sitePage->{SitePage::ID},
            ];

            if ($this->country !== 'default' && $lastChild->{SitePage::COUNTRY} === 'default')
            {
                SitePage::syncOverride($lastChild, $lastChildAttributes);
            }
            else
            {
                $lastChild->update($lastChildAttributes);
            }
        }

        return redirect(route('sites.edit', [
            'country' => $this->country,
            'site' => $site,
        ]))
            ->with('success', ModelService::getSuccessToast(SitePage::class, EventEnum::CREATED));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the last child of the parent.
     *
     * @param array $attributes
     *
     * @return ?SitePage
     */
    protected function findLastChild(array $attributes): ?SitePage
    {
        $parentId = Arr::get($attributes, SitePage::PARENT_ID);
        $siteId = Arr::get($attributes, SitePage::SITE_ID);

        $candidates = SitePage::query()
            ->where(SitePage::SITE_ID, $siteId)
            ->where(SitePage::PARENT_ID, $parentId)
            ->where(SitePage::RIGHT_ID, null)
            ->whereIn(SitePage::COUNTRY, [
                $this->country,
                'default'
            ])
            ->get();

        $sitePage = $candidates
            ->sortBy(function ($candidate)
            {
                return $candidate->{SitePage::COUNTRY} === $this->country ? 0 : 1;
            })
            ->first();

        return $sitePage;
    }

    #endregion
}
