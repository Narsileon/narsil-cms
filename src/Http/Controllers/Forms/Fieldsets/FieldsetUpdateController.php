<?php

namespace Narsil\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\FieldsetFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
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
     * @param Request $request
     * @param Fieldset $fieldset
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Fieldset $fieldset): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $fieldset);

        $data = $request->all();

        $rules = app(FieldsetFormRequest::class)
            ->rules($fieldset);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $fieldset->update($attributes);

        FieldsetService::syncFieldsetElements($fieldset, Arr::get($attributes, Fieldset::RELATION_ELEMENTS, []));

        return $this
            ->redirect(route('fieldsets.index'), $fieldset)
            ->with('success', ModelService::getSuccessMessage(Fieldset::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
