<?php

namespace Narsil\Cms\Http\Controllers\Collections\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Cms\Contracts\FormRequests\FieldFormRequest;
use Narsil\Cms\Enums\ModelEventEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Services\Models\FieldService;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param FieldFormRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(FieldFormRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $field = Field::create($attributes);

        $field
            ->blocks()
            ->sync(Arr::pluck(Arr::get($attributes, Field::RELATION_BLOCKS, []), Block::ID));

        $field
            ->validation_rules()
            ->sync(Arr::get($attributes, Field::RELATION_VALIDATION_RULES, []));

        FieldService::syncFieldOptions($field, Arr::get($attributes, Field::RELATION_OPTIONS));

        return $this
            ->redirect(route('fields.index'), $field)
            ->with('success', ModelService::getSuccessMessage(Field::class, ModelEventEnum::CREATED));
    }

    #endregion
}
