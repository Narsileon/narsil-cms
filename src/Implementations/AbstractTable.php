<?php

namespace Narsil\Cms\Implementations;

#region USE

use Illuminate\Support\Str;
use Narsil\Base\Contracts\Table;
use Narsil\Base\Services\TableService;
use Narsil\Cms\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractTable implements Table
{
    #region CONSTRUCTOR

    /**
     * @param string $table
     *
     * @return void
     */
    public function __construct(string $table)
    {
        $this->name = $table;

        $this->columns = $this->columns();
    }

    #endregion

    #region PROPERTIES

    /**
     * @var array<TableColumn> The columns of the table.
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
                'header' => $column->header ?? $this->getHeading($column->id),
                'id' => $column->id,
                'meta' => [
                    'field' => $column->getField($type),
                    'operators' => $column->getOperators($type),
                    'type' => $type,
                ],
            ];
        }

        return $columns;
    }

    /**
     * {@inheritDoc}
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
     * @param string $columnName
     *
     * @return string
     */
    public function getHeading(string $columnName): string
    {
        if (str_ends_with($columnName, '_id'))
        {
            $columnName = str_replace('_id', '', $columnName);
        }

        $translation = trans("narsil-cms::validation.attributes.$columnName");

        return Str::contains($translation, 'validation.attributes') ? $columnName : Str::ucfirst($translation);
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
     * @return array<TableColumn>
     */
    abstract protected function columns(): array;

    #endregion
}
