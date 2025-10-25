<?php

namespace Narsil\Implementations\Tables;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Entities\Entity;
use Narsil\Models\User;
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

        $accesorKeys = [
            Entity::CREATED_BY => Entity::RELATION_CREATOR . '.' . User::ATTRIBUTE_FULL_NAME,
            Entity::DELETED_BY => Entity::RELATION_REMOVER . '.' . User::ATTRIBUTE_FULL_NAME,
            Entity::UPDATED_BY => Entity::RELATION_EDITOR . '.' . User::ATTRIBUTE_FULL_NAME,
        ];

        $visibilities = [
            Entity::ID,
            Entity::CREATED_AT,
            Entity::UPDATED_AT,
        ];

        $columnListing = Schema::getColumnListing($this->name);

        foreach ($columnListing as $column)
        {
            $columns[] = new TableColumn(
                accessorKey: Arr::get($accesorKeys, $column),
                id: $column,
                visibility: in_array($column, $visibilities),
            );
        }

        return $columns;
    }

    #endregion
}
