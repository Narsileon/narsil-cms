<?php

namespace App\Structures;

#region USE

use Illuminate\Support\Arr;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class Column
{
    #region CONSTRUCTOR

    /**
     * @param array $column
     *
     * @return void
     */
    public function __construct(array $column)
    {
        $this->name = Arr::get($column, self::NAME, '');
        $this->type = Arr::get($column, self::TYPE_NAME, '');
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string
     */
    private const NAME = 'name';
    /**
     * @var string
     */
    private const TYPE_NAME = 'type_name';

    #endregion

    #region PROPERTIES

    /**
     * @var string
     */
    public readonly string $name;
    /**
     * @var string
     */
    public readonly string $type;

    #endregion
}
