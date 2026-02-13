<?php

namespace Narsil\Cms\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\DestroyManyRequest;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Footer::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Footer::query()
            ->whereIn(Footer::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('footers.index'))
            ->with('success', ModelService::getSuccessMessage(Footer::TABLE, ModelEventEnum::DELETED_MANY));
    }

    #endregion
}
