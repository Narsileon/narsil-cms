<?php

namespace Narsil\Http\Controllers\HostPages;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\HostPageFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostPage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageStoreController extends AbstractController
{
    #region CONSTRUCTORS

    /**
     * @return void
     */
    public function __construct()
    {
        $this->country = Session::get(HostPage::COUNTRY, 'default');
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
        $this->authorize(PermissionEnum::CREATE, HostPage::class);

        $data = $request->all();

        $rules = app(HostPageFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $attributes[HostPage::COUNTRY] = Session::get(HostPage::COUNTRY);

        $lastChild = $this->findLastChild($attributes);

        $hostPage = HostPage::create(array_merge($attributes, [
            HostPage::LEFT_ID => $lastChild?->{HostPage::ID},
        ]));

        if ($lastChild)
        {
            $lastChildAttributes = [
                HostPage::RIGHT_ID => $hostPage->{HostPage::ID},
            ];

            if ($this->country !== 'default' && $lastChild->{HostPage::COUNTRY} === 'default')
            {
                HostPage::syncOverride($lastChild, $lastChildAttributes);
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
            ->with('success', trans('narsil::toasts.success.host_pages.created'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the last child of the parent.
     *
     * @param array $attributes
     *
     * @return ?HostPage
     */
    protected function findLastChild(array $attributes): ?HostPage
    {
        $hostId = Arr::get($attributes, HostPage::HOST_ID);
        $parentId = Arr::get($attributes, HostPage::PARENT_ID);

        $candidates = HostPage::query()
            ->where(HostPage::HOST_ID, $hostId)
            ->where(HostPage::PARENT_ID, $parentId)
            ->where(HostPage::RIGHT_ID, null)
            ->whereIn(HostPage::COUNTRY, [
                $this->country,
                'default'
            ])
            ->get();

        $hostPage = $candidates
            ->sortBy(function ($candidate)
            {
                return $candidate->{HostPage::COUNTRY} === $this->country ? 0 : 1;
            })
            ->first();

        return $hostPage;
    }

    #endregion
}
