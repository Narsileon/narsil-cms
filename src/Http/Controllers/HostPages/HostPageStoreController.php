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
        $this->country = Session::get(HostLocale::COUNTRY, 'default');
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

        $hostLocale = $this->getHostLocale($attributes[HostPage::HOST_ID]);

        if ($hostLocale->{HostLocale::COUNTRY} !== 'default')
        {
            $attributes[HostPage::HOST_LOCALE_UUID] = $hostLocale?->{HostLocale::UUID};
        }

        $lastChild = $this->findLastChild($attributes);

        $hostPage = HostPage::create(array_merge($attributes, [
            HostPage::LEFT_ID => $lastChild?->{HostPage::ID},
        ]));

        if ($lastChild && $lastChild->{HostPage::RELATION_LOCALE}?->{HostLocale::COUNTRY} === $this->country)
        {
            $lastChild->update([
                HostPage::RIGHT_ID => $hostPage->{HostPage::ID},
            ]);
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
            ->with(HostPage::RELATION_LOCALE)
            ->where(HostPage::HOST_ID, $hostId)
            ->where(HostPage::PARENT_ID, $parentId)
            ->where(HostPage::RIGHT_ID, null)
            ->where(function ($query)
            {
                $query
                    ->whereDoesntHave(HostPage::RELATION_LOCALE)
                    ->orWhereHas(HostPage::RELATION_LOCALE, function ($subquery)
                    {
                        $subquery->where(HostLocale::COUNTRY, $this->country);
                    });
            })
            ->get();

        $hostPage = $candidates
            ->sortBy(function ($candidate)
            {
                return $candidate->{HostPage::RELATION_LOCALE}?->{HostLocale::COUNTRY} === $this->country ? 0 : 1;
            })
            ->first();

        return $hostPage;
    }

    /**
     * @param integer $hostId
     *
     * @return ?HostLocale
     */
    protected function getHostLocale(int $hostId): ?HostLocale
    {
        $hostLocale = HostLocale::query()
            ->with(HostLocale::RELATION_HOST)
            ->where(HostLocale::HOST_ID, $hostId)
            ->where(HostLocale::COUNTRY, $this->country)
            ->first();

        return $hostLocale;
    }

    #endregion
}
