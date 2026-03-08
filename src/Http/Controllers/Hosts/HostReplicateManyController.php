<?php

namespace Narsil\Cms\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Http\Requests\ReplicateManyRequest;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Actions\Hosts\ReplicateHost;
use Narsil\Cms\Models\Hosts\Host;

#endregion

/**
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
            app(ReplicateHost::class)
                ->run($host);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Host::TABLE, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
