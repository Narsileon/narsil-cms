<?php

namespace Narsil\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Services\Models\FormFieldsetService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetReplicateManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, FormFieldset::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $formFieldsets = FormFieldset::query()
            ->findMany($ids);

        foreach ($formFieldsets as $formFieldset)
        {
            FormFieldsetService::replicateFormFieldset($formFieldset);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(FormFieldset::class, EventEnum::REPLICATED_MANY));
    }

    #endregion
}
