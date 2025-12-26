<?php

namespace Narsil\Http\Controllers\Forms\Inputs;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\InputFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\Input;
use Narsil\Services\Models\InputService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class InputUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Input $input
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Input $input): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $input);

        $data = $request->all();

        $rules = app(InputFormRequest::class)
            ->rules($input);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $input->update($attributes);

        $input->validation_rules()->sync(Arr::get($attributes, Input::RELATION_VALIDATION_RULES, []));

        if ($options = Arr::get($attributes, Input::RELATION_OPTIONS))
        {
            InputService::syncInputOptions($input, $options);
        }

        return $this
            ->redirect(route('inputs.index'), $input)
            ->with('success', ModelService::getSuccessMessage(Input::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
