<?php

namespace Narsil\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Hosts\Host;

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
            ->with('success', trans('narsil::toasts.success.hosts.deleted_many'));
    }

    #endregion
}
