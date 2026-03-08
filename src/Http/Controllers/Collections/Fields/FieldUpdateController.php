<?php

namespace Narsil\Cms\Http\Controllers\Collections\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldBlocks;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldOptions;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldValidationRules;
use Narsil\Cms\Contracts\Requests\FieldFormRequest;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
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

        app(SyncFieldBlocks::class)
            ->run($field, Arr::pluck(Arr::get($attributes, Field::RELATION_BLOCKS, []), Block::ID));

        app(SyncFieldOptions::class)
            ->run($field, Arr::get($attributes, Field::RELATION_OPTIONS, []));

        app(SyncFieldValidationRules::class)
            ->run($field, Arr::get($attributes, Field::RELATION_VALIDATION_RULES, []));

        return $this
            ->redirect(route('fields.index'), $field)
            ->with('success', ModelService::getSuccessMessage(Field::TABLE, ModelEventEnum::UPDATED));
    }

    #endregion
}
