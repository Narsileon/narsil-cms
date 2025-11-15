<?php

namespace Narsil\Http\Controllers\Headers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\HeaderFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Globals\Header;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderUpdateController extends RedirectController
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
        $this->authorize(PermissionEnum::UPDATE, $header);

        $data = $request->all();

        $rules = app(HeaderFormRequest::class)
            ->rules($header);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $header->update($attributes);

        return $this
            ->redirect(route('headers.index'))
            ->with('success', trans('narsil::toasts.success.headers.updated'));
    }

    #endregion
}
