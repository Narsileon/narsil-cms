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
class FormStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param FormFormRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(FormFormRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $form = Form::create($attributes);

        FormService::syncFormTabs($form, Arr::get($attributes, Form::RELATION_TABS, []));

        return $this
            ->redirect(route('forms.index'))
            ->with('success', ModelService::getSuccessMessage(Form::class, ModelEventEnum::CREATED));
    }

    #endregion
}
