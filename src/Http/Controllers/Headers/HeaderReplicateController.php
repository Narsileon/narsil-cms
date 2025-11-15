<?php

namespace Narsil\Http\Controllers\Headers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Globals\Header;

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

        $replicated = $header->replicate();

        $replicated->save();

        return back()
            ->with('success', trans('narsil::toasts.success.headers.replicated'));
    }

    #endregion
}
