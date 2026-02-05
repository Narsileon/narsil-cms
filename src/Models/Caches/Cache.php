<?php

namespace Narsil\Cms\Models\Caches;

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
    final public const TABLE = 'cache';

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
     * The name of the "value" column.
     *
     * @var string
     */
    final public const VALUE = 'value';

    #endregion

    #endregion
}
