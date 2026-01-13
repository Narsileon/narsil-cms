<?php

namespace Narsil\Http\Controllers\Forms;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Contracts\FormRequests\FormFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\Form;
use Narsil\Services\Models\FormService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param FormFormRequest $request
     * @param Form $form
     *
     * @return RedirectResponse
     */
    public function __invoke(FormFormRequest $request, Form $form): RedirectResponse
    {
        $attributes = $request->validated();

        $form->update($attributes);

        FormService::syncFormSteps($form, Arr::get($attributes, Form::RELATION_TABS, []));

        return $this
            ->redirect(route('forms.index'))
            ->with('success', ModelService::getSuccessMessage(Form::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
