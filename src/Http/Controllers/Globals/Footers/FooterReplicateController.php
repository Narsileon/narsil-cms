<?php

namespace Narsil\Cms\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Actions\Footers\ReplicateFooter;
use Narsil\Cms\Models\Globals\Footer;

#endregion

/**
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

        app(ReplicateFooter::class)
            ->run($footer);

        return back()
            ->with('success', ModelService::getSuccessMessage(Footer::TABLE, ModelEventEnum::REPLICATED));
    }

    #endregion
}
