<?php

namespace App\Models;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Cache extends Model
{
    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "expiration" column.
     */
    public const EXPIRATION = 'expiration';
    /**
     * @var string The name of the "key" column.
     */
    public const KEY = 'key';
    /**
     * @var string The name of the "value" column.
     */
    public const VALUE = 'value';

    /**
     * @var string The name of the "cache" table.
     */
    public const TABLE = 'cache';

    #endregion
}
