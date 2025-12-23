<?php

namespace Narsil\Http\Controllers\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Globals\Footer;
use Narsil\Services\ModelService;

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
            ->with('success', ModelService::getSuccessToast(Footer::class, EventEnum::DELETED_MANY));
    }

    #endregion
}
