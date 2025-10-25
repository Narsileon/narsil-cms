<?php

namespace Narsil\Models\Jobs;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FailedJob extends Model
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
    final public const TABLE = 'failed_jobs';

    #region • COLUMNS

    /**
     * The name of the "connection" column.
     *
     * @var string
     */
    final public const CONNECTION = 'connection';

    /**
     * The name of the "exception" column.
     *
     * @var string
     */
    final public const EXCEPTION = 'exception';

    /**
     * The name of the "failed at" column.
     *
     * @var string
     */
    final public const FAILED_AT = 'failed_at';

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
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #endregion
}
