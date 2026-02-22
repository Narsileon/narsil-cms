<?php

namespace Narsil\Cms\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Services\FooterService;

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
        $this->authorize(AbilityEnum::CREATE, Footer::class);

        FooterService::replicate($footer);

        return back()
            ->with('success', ModelService::getSuccessMessage(Footer::TABLE, ModelEventEnum::REPLICATED));
    }

    #endregion
}
