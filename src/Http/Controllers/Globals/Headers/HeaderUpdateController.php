<?php

namespace Narsil\Cms\Http\Controllers\Globals\Headers;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Requests\HeaderFormRequest;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Globals\Header;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param HeaderFormRequest $request
     * @param Header $header
     *
     * @return RedirectResponse
     */
    public function __invoke(HeaderFormRequest $request, Header $header): RedirectResponse
    {
        $attributes = $request->validated();

        $header->update($attributes);

        return $this
            ->redirect(route('headers.index'))
            ->with('success', ModelService::getSuccessMessage(Header::TABLE, ModelEventEnum::UPDATED));
    }

    #endregion
}
