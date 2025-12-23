<?php

namespace Narsil\Http\Controllers\Forms;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\FormFormRequest;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\Form;
use Narsil\Services\MigrationService;
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
     * @param Request $request
     * @param Form $form
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Form $form): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $form);

        $data = $request->all();

        $rules = app(FormFormRequest::class)
            ->rules($form);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $form->update($attributes);

        if (Arr::get($data, '_dirty', false))
        {
            FormService::syncFormPages($form, Arr::get($attributes, Form::RELATION_PAGES, []));
        }

        return $this
            ->redirect(route('forms.index'))
            ->with('success', ModelService::getSuccessToast(Form::class, EventEnum::UPDATED));
    }

    #endregion
}
