<?php

namespace Narsil\Http\Controllers\Headers;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Globals\Header;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Header::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Header::query()
            ->whereIn(Header::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('headers.index'))
            ->with('success', ModelService::getSuccessToast(Header::class, EventEnum::DELETED_MANY));
    }

    #endregion
}
