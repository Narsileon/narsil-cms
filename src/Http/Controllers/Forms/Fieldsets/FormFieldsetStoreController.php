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
class FormFieldsetStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, FormFieldset::class);

        $data = $request->all();

        $rules = app(FormFieldsetFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $formFieldset = FormFieldset::create($attributes);

        if ($elements = Arr::get($attributes, FormFieldset::RELATION_ELEMENTS))
        {
            FormFieldsetService::syncFieldsetElements($formFieldset, $elements);
        }

        return $this
            ->redirect(route('form-fieldsets.index'), $formFieldset)
            ->with('success', ModelService::getSuccessMessage(FormFieldset::class, EventEnum::CREATED));
    }

    #endregion
}
