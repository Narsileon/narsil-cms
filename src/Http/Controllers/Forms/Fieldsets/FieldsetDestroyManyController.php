<?php

namespace Narsil\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Forms\Fieldset;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldsetDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Fieldset::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Fieldset::query()
            ->whereIn(Fieldset::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('fieldsets.index'))
            ->with('success', ModelService::getSuccessMessage(Fieldset::class, ModelEventEnum::DELETED_MANY));
    }

    #endregion
}
