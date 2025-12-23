<?php

namespace Narsil\Http\Controllers\Forms\Inputs;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Forms\FormInput;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormInputDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, FormInput::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        FormInput::query()
            ->whereIn(FormInput::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('form-inputs.index'))
            ->with('success', ModelService::getSuccessMessage(FormInput::class, EventEnum::DELETED_MANY));
    }

    #endregion
}
