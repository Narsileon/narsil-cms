<?php

namespace Narsil\Http\Controllers\Forms\Inputs;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\FormInput;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormInputDestroyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param FormInput $formInput
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, FormInput $formInput): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $formInput);

        $formInput->delete();

        return $this
            ->redirect(route('form-inputs.index'))
            ->with('success', trans('narsil::toasts.success.form-inputs.deleted'));
    }

    #endregion
}
