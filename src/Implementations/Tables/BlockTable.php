<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\TanStackTables\Columns\DateTimeColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\NumberColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\TextColumn;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;

#endregion

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
            NumberColumn::make(
                id: Block::ID,
                visibility: true,
            ),
            TextColumn::make(
                id: Block::HANDLE,
                visibility: true,
            ),
            TextColumn::make(
                id: Block::LABEL,
                visibility: true,
            ),
            NumberColumn::make(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Field::TABLE),
                id: Block::COUNT_FIELDS,
                visibility: true,
            ),
            NumberColumn::make(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Block::TABLE),
                id: Block::COUNT_BLOCKS,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Block::CREATED_AT,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Block::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
