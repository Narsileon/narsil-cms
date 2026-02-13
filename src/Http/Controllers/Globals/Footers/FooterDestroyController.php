<?php

namespace Narsil\Cms\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Services\ModelService;

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
        $this->authorize(PermissionEnum::DELETE, $footer);

        $footer->delete();

        return $this
            ->redirect(route('footers.index'))
            ->with('success', ModelService::getSuccessMessage(Footer::TABLE, ModelEventEnum::DELETED));
    }

    #endregion
}
