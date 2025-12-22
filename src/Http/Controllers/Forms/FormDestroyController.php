<?php

namespace Narsil\Http\Controllers\Forms;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\Form;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormDestroyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Form $form
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Form $form): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $form);

        $form->delete();

        return $this
            ->redirect(route('forms.index'))
            ->with('success', trans('narsil::toasts.success.forms.deleted'));
    }

    #endregion
}
