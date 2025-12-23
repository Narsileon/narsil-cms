<?php

namespace Narsil\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\FormFieldsetFormRequest;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Services\Models\FormFieldsetService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetUpdateController extends RedirectController
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
        $this->authorize(PermissionEnum::UPDATE, $formFieldset);

        $data = $request->all();

        $rules = app(FormFieldsetFormRequest::class)
            ->rules($formFieldset);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $formFieldset->update($attributes);

        if ($elements = Arr::get($attributes, FormFieldset::RELATION_ELEMENTS))
        {
            FormFieldsetService::syncFieldsetElements($formFieldset, $elements);
        }

        return $this
            ->redirect(route('form-fieldsets.index'), $formFieldset)
            ->with('success', ModelService::getSuccessToast(FormFieldset::class, EventEnum::UPDATED));
    }

    #endregion
}
