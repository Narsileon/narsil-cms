<?php

namespace Narsil\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetDestroyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param FormFieldset $formFieldset
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, FormFieldset $formFieldset): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $formFieldset);

        $formFieldset->delete();

        return $this
            ->redirect(route('form-fieldsets.index'))
            ->with('success', ModelService::getSuccessMessage(FormFieldset::class, ModelEventEnum::DELETED));
    }

    #endregion
}
