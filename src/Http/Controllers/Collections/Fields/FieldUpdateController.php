<?php

namespace Narsil\Cms\Http\Controllers\Collections\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Requests\FieldFormRequest;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Services\Models\FieldService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param FieldFormRequest $request
     * @param Field $field
     *
     * @return RedirectResponse
     */
    public function __invoke(FieldFormRequest $request, Field $field): RedirectResponse
    {
        $this->authorize(AbilityEnum::UPDATE, $field);

        $attributes = $request->validated();

        $field->update($attributes);

        $field
            ->blocks()
            ->sync(Arr::pluck(Arr::get($attributes, Field::RELATION_BLOCKS, []), Block::ID));

        $field
            ->validation_rules()
            ->sync(Arr::get($attributes, Field::RELATION_VALIDATION_RULES, []));

        FieldService::syncFieldOptions($field, Arr::get($attributes, Field::RELATION_OPTIONS));

        return $this
            ->redirect(route('fields.index'), $field)
            ->with('success', ModelService::getSuccessMessage(Field::TABLE, ModelEventEnum::UPDATED));
    }

    #endregion
}
