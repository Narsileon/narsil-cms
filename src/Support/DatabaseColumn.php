<?php

namespace Narsil\Cms\Support;

#region USE

use Illuminate\Support\Arr;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DatabaseColumn
{
    #region CONSTRUCTOR

    /**
     * @param array $column
     *
     * @return void
     */
    public function __construct(array $column)
    {
        $this->name = Arr::get($column, 'name', '');
        $this->type = Arr::get($column, 'type_name', '');
    }

    #endregion

    #region PROPERTIES

    /**
     * The name of the column.
     *
     * @var string
     */
    public readonly string $name;

    /**
     * The type of the column.
     *
     * @var string
     */
    public readonly string $type;

    #endregion
}
