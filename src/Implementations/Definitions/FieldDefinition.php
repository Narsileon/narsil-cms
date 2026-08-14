<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Definitions;

#region USE

use Narsil\Base\Resources\AbstractModelDefinition;
use Narsil\Cms\Contracts\Actions\Fields\ReplicateField;
use Narsil\Cms\Contracts\Forms\FieldForm;
use Narsil\Cms\Contracts\Requests\FieldFormRequest;
use Narsil\Cms\Models\Collections\Field;

#endregion

final class FieldDefinition extends AbstractModelDefinition
{
    #region PUBLIC METHODS

    public function editWith(): array
    {
        return [Field::RELATION_BLOCKS, Field::RELATION_OPTIONS, Field::RELATION_VALIDATION_RULES];
    }

    public function form(): ?string
    {
        return FieldForm::class;
    }

    public function indexWith(): array
    {
        return [Field::RELATION_BLOCKS, Field::RELATION_OPTIONS, Field::RELATION_VALIDATION_RULES];
    }

    public function model(): string
    {
        return Field::class;
    }

    public function replicateAction(): ?string
    {
        return ReplicateField::class;
    }

    public function request(): ?string
    {
        return FieldFormRequest::class;
    }

    public function route(): string
    {
        return 'fields';
    }

    #endregion
}
