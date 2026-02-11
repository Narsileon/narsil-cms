<?php

namespace Narsil\Cms\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\DestroyManyRequest;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Host::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Host::query()
            ->whereIn(Host::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('hosts.index'))
            ->with('success', ModelService::getSuccessMessage(Host::class, ModelEventEnum::DELETED_MANY));
    }

    #endregion
}
