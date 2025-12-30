<?php

namespace Narsil\Implementations\Tables;

#region USE

use Illuminate\Support\Facades\Schema;
use Narsil\Enums\DataTypeEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Entities\Entity;
use Narsil\Services\RouteService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityTable extends AbstractTable
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): array
    {
        return RouteService::getNames('collections', [
            'collection' => $this->name,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function columns(): array
    {
        $columns = [
            new TableColumn(
                id: Entity::ID,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Entity::SLUG,
                type: DataTypeEnum::STRING->value,
                visibility: true,
            ),
            new TableColumn(
                id: Entity::CREATED_AT,
                type: DataTypeEnum::STRING->value,
                visibility: true,
            ),
            new TableColumn(
                id: Entity::UPDATED_AT,
                type: DataTypeEnum::STRING->value,
                visibility: true,
            ),
        ];

        $columnListing = Schema::getColumnListing($this->name);

        foreach ($columnListing as $column)
        {
            $columns[] = new TableColumn(
                accessorKey: Entity::RELATION_DATA . '.' . $column,
                id: $column,
                visibility: false,
            );
        }

        return $columns;
    }

    #endregion
}
