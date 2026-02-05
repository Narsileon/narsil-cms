<?php

namespace Narsil\Cms\Http\Controllers\Globals\Headers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Cms\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Services\Models\HeaderService;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderReplicateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Header $header
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Header $header): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Header::class);

        HeaderService::replicate($header);

        return back()
            ->with('success', ModelService::getSuccessMessage(Header::class, ModelEventEnum::REPLICATED));
    }

    #endregion
}
