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
class FieldsetStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Fieldset::class);

        $data = $request->all();

        $rules = app(FieldsetFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $fieldset = Fieldset::create($attributes);

        if ($elements = Arr::get($attributes, Fieldset::RELATION_ELEMENTS))
        {
            FieldsetService::syncFieldsetElements($fieldset, $elements);
        }

        return $this
            ->redirect(route('fieldsets.index'), $fieldset)
            ->with('success', ModelService::getSuccessMessage(Fieldset::class, ModelEventEnum::CREATED));
    }

    #endregion
}
