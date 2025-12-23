<?php

namespace Narsil\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, FormFieldset::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        FormFieldset::query()
            ->whereIn(FormFieldset::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('form-fieldsets.index'))
            ->with('success', ModelService::getSuccessMessage(FormFieldset::class, EventEnum::DELETED_MANY));
    }

    #endregion
}
