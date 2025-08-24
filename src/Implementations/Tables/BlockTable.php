<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Implementations\AbstractTable;
use Narsil\Models\Elements\Block;
use Narsil\Support\TableColumn;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
                header: trans('narsil::tables.fields'),
                id: Block::COUNT_FIELDS,
                visibility: true,
            ),
            new TableColumn(
                header: trans('narsil::tables.blocks'),
                id: Block::COUNT_BLOCKS,
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
