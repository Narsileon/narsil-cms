<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\DataTypeEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;
use Narsil\Services\ModelService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockTable extends AbstractTable
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

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function columns(): array
    {
        return [
            new TableColumn(
                id: Block::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Block::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: Block::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(Field::TABLE),
                id: Block::COUNT_FIELDS,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(Block::TABLE),
                id: Block::COUNT_BLOCKS,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Block::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Block::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
