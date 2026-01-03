<?php

namespace Narsil\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Contracts\FormRequests\FieldsetFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\Fieldset;
use Narsil\Services\Models\FieldsetService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldsetUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param FieldsetFormRequest $request
     * @param Fieldset $fieldset
     *
     * @return RedirectResponse
     */
    public function __invoke(FieldsetFormRequest $request, Fieldset $fieldset): RedirectResponse
    {
        $attributes = $request->validated();

        $fieldset->update($attributes);

        FieldsetService::syncFieldsetElements($fieldset, Arr::get($attributes, Fieldset::RELATION_ELEMENTS, []));

        return $this
            ->redirect(route('fieldsets.index'), $fieldset)
            ->with('success', ModelService::getSuccessMessage(Fieldset::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
