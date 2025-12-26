<?php

namespace Narsil\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\FooterFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Globals\Footer;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterUpdateController extends RedirectController
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
        $this->authorize(PermissionEnum::UPDATE, $footer);

        $data = $request->all();

        $rules = app(FooterFormRequest::class)
            ->rules($footer);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $footer->update($attributes);

        return $this
            ->redirect(route('footers.index'))
            ->with('success', ModelService::getSuccessMessage(Footer::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
