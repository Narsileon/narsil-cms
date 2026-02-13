<?php

namespace Narsil\Cms\Http\Controllers\Globals\Headers;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\DestroyManyRequest;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Services\ModelService;

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
            ->with('success', ModelService::getSuccessMessage(Header::TABLE, ModelEventEnum::DELETED_MANY));
    }

    #endregion
}
