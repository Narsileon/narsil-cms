<?php

namespace Narsil\Http\Controllers\Forms\Inputs;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\FormInput;
use Narsil\Services\Models\FormInputService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormInputReplicateController extends RedirectController
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
        $this->authorize(PermissionEnum::CREATE, FormInput::class);

        FormInputService::replicateFormInput($formInput);

        return back()
            ->with('success', ModelService::getSuccessMessage(FormInput::class, EventEnum::REPLICATED));
    }

    #endregion
}
