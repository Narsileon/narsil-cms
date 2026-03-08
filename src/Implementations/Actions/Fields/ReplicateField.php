<?php

namespace Narsil\Cms\Implementations\Actions\Fields;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Base\Services\DatabaseService;
use Narsil\Cms\Contracts\Actions\Fields\ReplicateField as Contract;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldBlocks;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldOptions;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldValidationRules;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\ValidationRule;

#endregion

/**
 * @author Jonathan Rigaux
 */
class ReplicateField extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Field $field): Field
    {
        $replicated = $field->replicate();

        $replicated
            ->fill([
                Field::HANDLE => DatabaseService::generateUniqueValue($replicated, Field::HANDLE, $field->{Field::HANDLE}),
            ])
            ->save();

        $blocks = $field->{Field::RELATION_BLOCKS}->pluck(ValidationRule::ID)->toArray();

        app(SyncFieldBlocks::class)
            ->run($replicated, $blocks);

        $options = $field->options()->get()->toArray();

        app(SyncFieldOptions::class)
            ->run($replicated, $options);

        $validationRules = $field->{Field::RELATION_VALIDATION_RULES}->pluck(ValidationRule::ID)->toArray();

        app(SyncFieldValidationRules::class)
            ->run($replicated, $validationRules);

        return $replicated;
    }

    #endregion
}
