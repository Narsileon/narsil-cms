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
class FooterStoreController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Footer::class);

        $data = $request->all();

        $rules = app(FooterFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        Footer::create($attributes);

        return $this
            ->redirect(route('footers.index'))
            ->with('success', trans('narsil::toasts.success.footers.created'));
    }

    #endregion
}
