<?php

namespace Narsil\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Globals\Footer;
use Narsil\Services\Models\FooterService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterReplicateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Footer $footer
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Footer $footer): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Footer::class);

        FooterService::replicate($footer);

        return back()
            ->with('success', ModelService::getSuccessMessage(Footer::class, ModelEventEnum::REPLICATED));
    }

    #endregion
}
