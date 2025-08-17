<?php

namespace Narsil\Implementations\Tables;

#region USE

use Illuminate\Support\Facades\Schema;
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
        $columns = [];

        $visibilities = [
            Entity::ID,
            Entity::CREATED_AT,
            Entity::UPDATED_AT,
        ];

        $columnListing = Schema::getColumnListing($this->name);

        foreach ($columnListing as $column)
        {
            $columns[] = new TableColumn(
                id: $column,
                visibility: in_array($column, $visibilities),
            );
        }

        return $columns;
    }

    #endregion
}
