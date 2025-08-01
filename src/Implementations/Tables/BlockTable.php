<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Contracts\Tables\BlockTable as Contract;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Elements\Block;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockTable extends AbstractTable implements Contract
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
                header: trans('narsil-cms::ui.fields'),
                id: Block::COUNT_FIELDS,
                visibility: true,
            ),
            new TableColumn(
                header: trans('narsil-cms::ui.blocks'),
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
