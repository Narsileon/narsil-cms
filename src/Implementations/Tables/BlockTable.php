<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\Forms\Inputs\DatetimeInputData;
use Narsil\Base\Http\Data\Forms\Inputs\NumberInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Http\Data\TanStackTables\ColumnDefData;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockTable extends Table
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Block::TABLE);
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
                id: Block::ID,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Block::HANDLE,
                type: TextInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Block::LABEL,
                type: TextInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Field::TABLE),
                id: Block::COUNT_FIELDS,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Block::TABLE),
                id: Block::COUNT_BLOCKS,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Block::CREATED_AT,
                type: DatetimeInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Block::UPDATED_AT,
                type: DatetimeInputData::TYPE,
                visibility: true,
            ),
        ];
    }

    #endregion
}
