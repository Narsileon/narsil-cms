<?php

namespace Narsil\Http\Controllers\Forms\Inputs;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Forms\FormInput;
use Narsil\Services\Models\FormInputService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormInputReplicateManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, FormInput::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $formInputs = FormInput::query()
            ->findMany($ids);

        foreach ($formInputs as $formInput)
        {
            FormInputService::replicateFormInput($formInput);
        }

        return back()
            ->with('success', trans('narsil::toasts.success.form-inputs.replicated_many'));
    }

    #endregion
}
