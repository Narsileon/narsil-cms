<?php

namespace Narsil\Cms\Models\Jobs;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Job extends Model
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
    final public const TABLE = 'jobs';

    #region • COLUMNS

    /**
     * The name of the "attempts" column.
     *
     * @var string
     */
    final public const ATTEMPTS = 'attempts';

    /**
     * The name of the "available at" column.
     *
     * @var string
     */
    final public const AVAILABLE_AT = 'available_at';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "payload" column.
     *
     * @var string
     */
    final public const PAYLOAD = 'payload';

    /**
     * The name of the "queue" column.
     *
     * @var string
     */
    final public const QUEUE = 'queue';

    /**
     * The name of the "reserved at" column.
     *
     * @var string
     */
    final public const RESERVED_AT = 'reserved_at';

    #endregion

    #endregion
}
