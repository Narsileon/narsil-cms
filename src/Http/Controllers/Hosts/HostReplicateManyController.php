<?php

namespace Narsil\Cms\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\ReplicateManyRequest;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Services\HostService;

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
        $this->authorize(AbilityEnum::CREATE, Host::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $hosts = Host::query()
            ->findMany($ids);

        foreach ($hosts as $host)
        {
            HostService::replicate($host);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Host::TABLE, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
