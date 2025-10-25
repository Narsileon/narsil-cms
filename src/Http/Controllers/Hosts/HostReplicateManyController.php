<?php

namespace Narsil\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Hosts\Host;
use Narsil\Services\HostService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostReplicateManyController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Host::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $hosts = Host::query()
            ->findMany($ids);

        foreach ($hosts as $host)
        {
            HostService::replicateHost($host);
        }

        return back()
            ->with('success', trans('narsil::toasts.success.hosts.replicated_many'));
    }

    #endregion
}
