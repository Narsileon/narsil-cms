<?php

namespace Narsil\Http\Controllers\Headers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\HeaderFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Globals\Header;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Header::class);

        $data = $request->all();

        $rules = app(HeaderFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        Header::create($attributes);

        return $this
            ->redirect(route('headers.index'))
            ->with('success', ModelService::getSuccessMessage(Header::class, ModelEventEnum::CREATED));
    }

    #endregion
}
