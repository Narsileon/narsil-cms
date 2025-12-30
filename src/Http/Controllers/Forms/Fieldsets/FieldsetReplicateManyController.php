<?php

namespace Narsil\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Forms\Fieldset;
use Narsil\Services\Models\FieldsetService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldsetReplicateManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Fieldset::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $fieldsets = Fieldset::query()
            ->findMany($ids);

        foreach ($fieldsets as $fieldset)
        {
            FieldsetService::replicate($fieldset);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Fieldset::class, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
