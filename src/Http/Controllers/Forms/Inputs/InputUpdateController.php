<?php

namespace Narsil\Cms\Http\Controllers\Forms\Inputs;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Cms\Contracts\FormRequests\InputFormRequest;
use Narsil\Cms\Enums\ModelEventEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Forms\Input;
use Narsil\Cms\Services\Models\InputService;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class InputUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param InputFormRequest $request
     * @param Input $input
     *
     * @return RedirectResponse
     */
    public function __invoke(InputFormRequest $request, Input $input): RedirectResponse
    {
        $attributes = $request->validated();

        $input->update($attributes);

        $input
            ->validation_rules()
            ->sync(Arr::get($attributes, Input::RELATION_VALIDATION_RULES, []));

        InputService::syncInputOptions($input, Arr::get($attributes, Input::RELATION_OPTIONS));

        return $this
            ->redirect(route('inputs.index'), $input)
            ->with('success', ModelService::getSuccessMessage(Input::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
