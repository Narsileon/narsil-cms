<?php

namespace Narsil\Cms\Http\Controllers\Globals\Headers;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Requests\HeaderFormRequest;
use Narsil\Cms\Models\Globals\Header;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param HeaderFormRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(HeaderFormRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        Header::create($attributes);

        return $this
            ->redirect(route('headers.index'))
            ->with('success', ModelService::getSuccessMessage(Header::TABLE, ModelEventEnum::CREATED));
    }

    #endregion
}
