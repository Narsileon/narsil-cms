<?php

namespace App\Models;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CacheLock extends Model
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
    final public const EXPIRATION = 'expiration';
    /**
     * @var string The name of the "key" column.
     */
    final public const KEY = 'key';
    /**
     * @var string The name of the "owner" column.
     */
    final public const OWNER = 'owner';

    /**
     * @var string The name of the "cache locks" table.
     */
    final public const TABLE = 'cache_locks';

    #endregion
}
