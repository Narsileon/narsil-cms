<?php

namespace Narsil\Cms\Http\Controllers\Forms;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Cms\Contracts\FormRequests\FormFormRequest;
use Narsil\Cms\Enums\ModelEventEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Forms\Form;
use Narsil\Cms\Services\Models\FormService;
use Narsil\Cms\Services\ModelService;

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

        FormService::syncFormSteps($form, Arr::get($attributes, Form::RELATION_STEPS, []));
        FormService::syncFormWebhooks($form, Arr::get($attributes, Form::RELATION_WEBHOOKS, []));

        return $this
            ->redirect(route('forms.index'))
            ->with('success', ModelService::getSuccessMessage(Form::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
