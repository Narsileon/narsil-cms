<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Enums\InputTypeEnum;
use Narsil\Base\Http\Data\TanStackTables\ColumnDefData;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Implementations\AbstractTable;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\ValidationRule;

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
            new ColumnDefData(
                id: Field::ID,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                id: Field::HANDLE,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                id: Field::LABEL,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                id: Field::DESCRIPTION,
                type: InputTypeEnum::TEXT,
            ),
            new ColumnDefData(
                id: Field::PLACEHOLDER,
                type: InputTypeEnum::TEXT,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(ValidationRule::TABLE),
                id: Field::COUNT_VALIDATION_RULES,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                id: Field::CREATED_AT,
                type: InputTypeEnum::DATETIME,
                visibility: true,
            ),
            new ColumnDefData(
                id: Field::UPDATED_AT,
                type: InputTypeEnum::DATETIME,
                visibility: true,
            ),
        ];
    }

    #endregion
}
