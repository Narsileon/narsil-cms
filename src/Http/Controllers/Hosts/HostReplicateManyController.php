<?php

namespace Narsil\Cms\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Cms\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\ReplicateManyRequest;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Services\Models\HostService;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostReplicateManyController extends RedirectController
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
            HostService::replicate($host);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Host::class, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
