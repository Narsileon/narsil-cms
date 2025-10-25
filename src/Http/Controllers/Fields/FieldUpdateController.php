<?php

namespace Narsil\Http\Controllers\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\FieldFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Elements\Field;
use Narsil\Services\FieldService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldUpdateController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Field $field): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $field);

        $data = $request->all();

        $rules = app(FieldFormRequest::class)->rules($field);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $field->update($attributes);

        if ($options = Arr::get($attributes, Field::RELATION_OPTIONS))
        {
            FieldService::syncOptions($field, $options);
        }

        return $this
            ->redirect(route('fields.index'), $field)
            ->with('success', trans('narsil::toasts.success.fields.updated'));
    }

    #endregion
}
