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
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Form::class);

        $data = $request->all();

        $rules = app(FormFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $form = Form::create($attributes);

        FormService::syncFormPages($form, Arr::get($attributes, Form::RELATION_PAGES, []));

        return $this
            ->redirect(route('forms.index'))
            ->with('success', ModelService::getSuccessToast(Form::class, EventEnum::CREATED));
    }

    #endregion
}
