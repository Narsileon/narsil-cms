<?php

namespace Narsil\Http\Controllers\HostPages;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\HostPageFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostPage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageStoreController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, HostPage::class);

        $data = $request->all();

        $rules = app(HostPageFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $hostLocale = static::getHostLocale($attributes[HostPage::HOST_ID]);

        if ($hostLocale->{HostLocale::COUNTRY} !== 'default')
        {
            $attributes[HostPage::HOST_LOCALE_UUID] = $hostLocale?->{HostLocale::UUID};
        }

        $lastChild = static::findLastChild($attributes);

        $hostPage = HostPage::create(array_merge($attributes, [
            HostPage::LEFT_ID => $lastChild?->{HostPage::ID},
        ]));

        if ($lastChild)
        {
            $lastChild->update([
                HostPage::RIGHT_ID => $hostPage->{HostPage::ID},
            ]);
        }

        return redirect(route('sites.edit', $hostLocale->{HostLocale::RELATION_HOST}->{Host::HANDLE}))
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
    protected static function findLastChild(array $attributes): ?HostPage
    {
        $hostId = Arr::get($attributes, HostPage::HOST_ID);
        $parentId = Arr::get($attributes, HostPage::PARENT_ID);

        $hostPage = HostPage::query()
            ->where(HostPage::HOST_ID, $hostId)
            ->where(HostPage::PARENT_ID, $parentId)
            ->where(HostPage::RIGHT_ID, null)
            ->first();

        return $hostPage;
    }

    /**
     * @param integer $hostId
     *
     * @return ?HostLocale
     */
    protected static function getHostLocale(int $hostId): ?HostLocale
    {
        $country = request()->get('country', 'default');

        $hostLocale = HostLocale::query()
            ->with(HostLocale::RELATION_HOST)
            ->where(HostLocale::HOST_ID, $hostId)
            ->where(HostLocale::COUNTRY, $country)
            ->first();

        return $hostLocale;
    }

    #endregion
}
