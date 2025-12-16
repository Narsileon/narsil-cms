<?php

namespace Narsil\Implementations\Tables;

#region USE

use Illuminate\Support\Str;
use Narsil\Enums\Database\TypeNameEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Elements\Block;
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
                header: Str::ucfirst(trans('narsil::tables.fields')),
                id: Block::COUNT_FIELDS,
                type: TypeNameEnum::INTEGER->value,
                visibility: true,

            ),
            new TableColumn(
                header: Str::ucfirst(trans('narsil::tables.blocks')),
                id: Block::COUNT_BLOCKS,
                type: TypeNameEnum::INTEGER->value,
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
