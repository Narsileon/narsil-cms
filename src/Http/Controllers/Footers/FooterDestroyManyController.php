<?php

namespace Narsil\Http\Controllers\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Globals\Footer;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterDestroyManyController extends AbstractController
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
            ->with('success', trans('narsil::toasts.success.footers.deleted_many'));
    }

    #endregion
}
