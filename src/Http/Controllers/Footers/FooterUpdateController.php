<?php

namespace Narsil\Http\Controllers\Footers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\FooterFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Globals\Footer;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterUpdateController extends AbstractController
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
            ->with('success', trans('narsil::toasts.success.footers.updated'));
    }

    #endregion
}
