<?php

namespace Narsil\Implementations;

#region USE

use Narsil\Contracts\Table;
use Narsil\Services\RouteService;
use Narsil\Services\TableService;
use Narsil\Support\TanStackColumn;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class AbstractTable implements Table
{
    #region CONSTRUCTOR

    public function __construct(string $table)
    {
        $this->name = $table;

        $this->columns = $this->columns();
    }

    #endregion

    #region PROPERTIES

    /**
     * @var array<TanStackColumn> The columns of the table.
     */
    public readonly array $columns;
    /**
     * @var string The name of the table.
     */
    public readonly string $name;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function getColumns(): array
    {
        $tableColumns = TableService::getColumns($this->name);

        $columns = [];

        foreach ($this->columns as $column)
        {
            $tableColumn = $tableColumns->get($column->id);
            $type = $column->type ?? $tableColumn?->type;

            $columns[] = [
                'accessorKey' => $column->accessorKey ?? $column->id,
                'header' => $column->header ?? TableService::getHeading($column->id),
                'id' => $column->id,
                'meta' => [
                    'operators' => $column->getOperators($type),
                    'type' => $type,
                ],
            ];
        }

        return $columns;
    }

    /**
     * @return array
     */
    public function getColumnOrder(): array
    {
        $columnOrder = [];

        foreach ($this->columns as $column)
        {
            $columnOrder[] = $column->id;
        }

        return $columnOrder;
    }

    /**
     * {@inheritDoc}
     */
    public function getColumnVisibility(): array
    {
        $columnVisibility = [];

        foreach ($this->columns as $column)
        {
            $columnVisibility[$column->id] = $column->visibility;
        }

        return $columnVisibility;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): array
    {
        return RouteService::getNames($this->name);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<TanStackColumn>
     */
    abstract protected function columns(): array;

    #endregion
}
