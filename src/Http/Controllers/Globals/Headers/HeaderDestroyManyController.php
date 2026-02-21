<?php

namespace Narsil\Cms\Http\Controllers\Globals\Headers;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\DestroyManyRequest;
use Narsil\Cms\Models\Globals\Header;

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
        $this->authorize(AbilityEnum::DELETE_ANY, Header::class);

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
