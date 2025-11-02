<?php

namespace Narsil\Http\Controllers\HostPages;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostPage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageDestroyController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param HostPage $hostPage
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, HostPage $hostPage): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $hostPage);

        $site = $this->getSite($hostPage);

        $hostPage->delete();

        return redirect(route('sites.edit', $site))
            ->with('success', trans('narsil::toasts.success.host_pages.deleted'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param HostPage $hostPage
     *
     * @return string
     */
    final protected function getSite(HostPage $hostPage): string
    {
        $hostPage->loadMissing(HostPage::RELATION_HOST);

        return $hostPage->{HostPage::RELATION_HOST}->{Host::HANDLE};
    }

    #endregion
}
