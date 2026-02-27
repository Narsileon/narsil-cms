<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\Forms\Inputs\DatetimeInputData;
use Narsil\Base\Http\Data\Forms\Inputs\NumberInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Http\Data\TanStackTables\ColumnDefData;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityTable extends Table
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function columns(): array
    {
        return [
            new ColumnDefData(
                id: Entity::ID,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Entity::SLUG,
                type: TextInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Entity::CREATED_AT,
                type: DatetimeInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Entity::UPDATED_AT,
                type: DatetimeInputData::TYPE,
                visibility: true,
            ),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function routes(): array
    {
        return RouteService::getNames('collections', [
            'collection' => $this->name,
        ]);
    }

    #endregion
}
