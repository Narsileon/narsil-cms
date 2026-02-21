<?php

namespace Narsil\Cms\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Globals\Footer;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterDestroyController extends RedirectController
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
        $this->authorize(AbilityEnum::DELETE, $footer);

        $footer->delete();

        return $this
            ->redirect(route('footers.index'))
            ->with('success', ModelService::getSuccessMessage(Footer::TABLE, ModelEventEnum::DELETED));
    }

    #endregion
}
