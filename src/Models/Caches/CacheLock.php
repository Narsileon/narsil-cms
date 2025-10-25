<?php

namespace Narsil\Models\Caches;

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
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'cache_locks';

    #region • COLUMNS

    /**
     * The name of the "expiration" column.
     *
     * @var string
     */
    final public const EXPIRATION = 'expiration';

    /**
     * The name of the "key" column.
     *
     * @var string
     */
    final public const KEY = 'key';

    /**
     * The name of the "owner" column.
     *
     * @var string
     */
    final public const OWNER = 'owner';

    #endregion

    #endregion
}
