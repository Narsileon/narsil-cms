<?php

declare(strict_types=1);

namespace Narsil\Cms\Definitions;

#region USE

use Narsil\Base\Definitions\AbstractModelDefinition;
use Narsil\Base\Enums\ModelHookEventEnum;
use Narsil\Base\Http\Data\ModelHookContext;
use Illuminate\Support\Arr;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldBlocks;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldOptions;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldValidationRules;
use Narsil\Cms\Contracts\Actions\Fields\ReplicateField;
use Narsil\Cms\Contracts\Forms\FieldForm;
use Narsil\Cms\Contracts\Requests\FieldFormRequest;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Implementations\Tables\FieldTable;

#endregion

final class FieldDefinition extends AbstractModelDefinition
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function editWith(): array
    {
        return [Field::RELATION_BLOCKS, Field::RELATION_OPTIONS, Field::RELATION_VALIDATION_RULES];
    }

    /**
     * {@inheritDoc}
     */
    public function form(): ?string
    {
        return FieldForm::class;
    }

    /**
     * {@inheritDoc}
     */
    public function hooks(): array
    {
        $hook = function (ModelHookContext $context): void
        {
            if ($context->model instanceof Field)
            {
                app(SyncFieldBlocks::class)->run($context->model, Arr::pluck(Arr::get($context->attributes, Field::RELATION_BLOCKS, []), Block::ID));
                app(SyncFieldOptions::class)->run($context->model, Arr::get($context->attributes, Field::RELATION_OPTIONS, []));
                app(SyncFieldValidationRules::class)->run($context->model, Arr::get($context->attributes, Field::RELATION_VALIDATION_RULES, []));
            }
        };

        return [
            ModelHookEventEnum::AFTER_STORE->value => [
                ['hook' => $hook, 'priority' => 0],
            ],
            ModelHookEventEnum::AFTER_UPDATE->value => [
                ['hook' => $hook, 'priority' => 0],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function indexWith(): array
    {
        return [Field::RELATION_BLOCKS, Field::RELATION_OPTIONS, Field::RELATION_VALIDATION_RULES];
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Field::class;
    }

    /**
     * {@inheritDoc}
     */
    public function morph(): ?string
    {
        return Field::TABLE;
    }

    /**
     * {@inheritDoc}
     */
    public function replicateAction(): ?string
    {
        return ReplicateField::class;
    }

    /**
     * {@inheritDoc}
     */
    public function request(): ?string
    {
        return FieldFormRequest::class;
    }

    /**
     * {@inheritDoc}
     */
    public function route(): string
    {
        return 'fields';
    }

    /**
     * {@inheritDoc}
     */
    public function table(): ?string
    {
        return FieldTable::class;
    }

    #endregion
}
