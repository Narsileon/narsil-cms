<?php

namespace Narsil\Http\Controllers\Globals\Headers;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Contracts\FormRequests\HeaderFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Globals\Header;
use Narsil\Services\ModelService;

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
            ->with('success', ModelService::getSuccessMessage(Header::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
