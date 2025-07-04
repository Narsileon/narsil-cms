<?php

namespace App\Models;

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
     * @var string The name of the "connection" column.
     */
    final public const CONNECTION = 'connection';
    /**
     * @var string The name of the "exception" column.
     */
    final public const EXCEPTION = 'exception';
    /**
     * @var string The name of the "failed at" column.
     */
    final public const FAILED_AT = 'failed_at';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "payload" column.
     */
    final public const PAYLOAD = 'payload';
    /**
     * @var string The name of the "queue" column.
     */
    final public const QUEUE = 'queue';
    /**
     * @var string The name of the "uuid" column.
     */
    final public const UUID = 'uuid';

    /**
     * @var string The name of the "failed jobs" table.
     */
    final public const TABLE = 'failed_jobs';

    #endregion
}
