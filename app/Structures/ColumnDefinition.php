<?php

namespace App\Structures;

#region USE

use Illuminate\Support\Arr;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class ColumnDefinition
{
    #region CONSTRUCTOR

    /**
     * @param Column $column
     *
     * @return void
     */
    public function __construct(Column $column)
    {
        $this->column = [
            self::ACCESSOR_KEY => $column->name,
            self::HEADER => $this->getHeader($column),
            self::ID => $column->name,
            self::TYPE => $column->type,
        ];
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string
     */
    public const ACCESSOR_KEY = 'accessorKey';
    /**
     * @var string
     */
    public const HEADER = 'header';
    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const TYPE = 'type';

    #endregion

    #region PROPERTIES

    /**
     * @var array<string,mixed>
     */
    protected array $column = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * Gets the model column.
     *
     * @param string|null $key
     *
     * @return mixed
     */
    public function get(string|null $key = null): mixed
    {
        return Arr::get($this->column, $key);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param Column $column
     *
     * @return string
     */
    private function getHeader(Column $column): string
    {
        return trans("validation.attributes.$column->name");
    }

    #endregion
}
