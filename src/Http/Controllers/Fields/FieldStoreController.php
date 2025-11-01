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
class FieldStoreController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Field::class);

        $data = $request->all();

        $rules = app(FieldFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $field = Field::create($attributes);

        if ($options = Arr::get($attributes, Field::RELATION_OPTIONS))
        {
            FieldService::syncOptions($field, $options);
        }

        return $this
            ->redirect(route('fields.index'), $field)
            ->with('success', trans('narsil::toasts.success.fields.created'));
    }

    #endregion
}
