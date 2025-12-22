<?php

namespace Narsil\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Hosts\Host;
use Narsil\Services\Models\HostService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostReplicateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Host $host
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Host $host): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Host::class);

        HostService::replicateHost($host);

        return back()
            ->with('success', trans('narsil::toasts.success.hosts.replicated'));
    }

    #endregion
}
