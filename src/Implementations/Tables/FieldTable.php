<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\DataTypeEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Collections\Field;
use Narsil\Models\ValidationRule;
use Narsil\Services\ModelService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Field::TABLE);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function columns(): array
    {
        return [
            new TableColumn(
                id: Field::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Field::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                id: Field::LABEL,
                visibility: true,
            ),
            new TableColumn(
                id: Field::DESCRIPTION,
                visibility: false,
            ),
            new TableColumn(
                id: Field::PLACEHOLDER,
                visibility: false,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(ValidationRule::TABLE),
                id: Field::COUNT_VALIDATION_RULES,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Field::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Field::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
