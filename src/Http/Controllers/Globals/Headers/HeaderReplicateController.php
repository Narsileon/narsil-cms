<?php

namespace Narsil\Cms\Http\Controllers\Globals\Headers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Actions\Headers\ReplicateHeader;
use Narsil\Cms\Models\Globals\Header;

#endregion

/**
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
        $this->authorize(AbilityEnum::CREATE, Header::class);

        app(ReplicateHeader::class)
            ->run($header);

        return back()
            ->with('success', ModelService::getSuccessMessage(Header::TABLE, ModelEventEnum::REPLICATED));
    }

    #endregion
}
