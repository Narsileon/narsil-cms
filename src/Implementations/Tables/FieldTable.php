<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\Forms\Inputs\DatetimeInputData;
use Narsil\Base\Http\Data\Forms\Inputs\NumberInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Http\Data\TanStackTables\ColumnDefData;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\ValidationRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldTable extends Table
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

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function columns(): array
    {
        return [
            new ColumnDefData(
                id: Field::ID,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Field::HANDLE,
                type: TextInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Field::LABEL,
                type: TextInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Field::DESCRIPTION,
                type: TextInputData::TYPE,
            ),
            new ColumnDefData(
                id: Field::PLACEHOLDER,
                type: TextInputData::TYPE,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(ValidationRule::TABLE),
                id: Field::COUNT_VALIDATION_RULES,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Field::CREATED_AT,
                type: DatetimeInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Field::UPDATED_AT,
                type: DatetimeInputData::TYPE,
                visibility: true,
            ),
        ];
    }

    #endregion
}
