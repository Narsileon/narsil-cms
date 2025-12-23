<?php

namespace Narsil\Http\Controllers\Forms\Inputs;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\FormInputFormRequest;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\FormInput;
use Narsil\Services\Models\FormInputService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormInputStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, FormInput::class);

        $data = $request->all();

        $rules = app(FormInputFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $formInput = FormInput::create($attributes);

        if ($options = Arr::get($attributes, FormInput::RELATION_OPTIONS))
        {
            FormInputService::syncFormInputOptions($formInput, $options);
        }

        return $this
            ->redirect(route('form-inputs.index'), $formInput)
            ->with('success', ModelService::getSuccessMessage(FormInput::class, EventEnum::CREATED));
    }

    #endregion
}
