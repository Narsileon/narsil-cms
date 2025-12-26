<?php

namespace Narsil\Http\Controllers\Structures\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\FieldFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;
use Narsil\Services\Models\FieldService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldStoreController extends RedirectController
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

        $field->blocks()->sync(Arr::pluck(Arr::get($attributes, Field::RELATION_BLOCKS, []), Block::ID));
        $field->validation_rules()->sync(Arr::get($attributes, Field::RELATION_VALIDATION_RULES, []));

        if ($options = Arr::get($attributes, Field::RELATION_OPTIONS))
        {
            FieldService::syncFieldOptions($field, $options);
        }

        return $this
            ->redirect(route('fields.index'), $field)
            ->with('success', ModelService::getSuccessMessage(Field::class, ModelEventEnum::CREATED));
    }

    #endregion
}
