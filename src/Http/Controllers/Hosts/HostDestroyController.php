<?php

namespace Narsil\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Hosts\Host;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostDestroyController extends RedirectController
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
        $this->authorize(PermissionEnum::DELETE, $host);

        $host->delete();

        return $this
            ->redirect(route('hosts.index'))
            ->with('success', ModelService::getSuccessToast(Host::class, EventEnum::DELETED));
    }

    #endregion
}
