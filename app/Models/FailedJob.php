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
    public const CONNECTION = 'connection';
    /**
     * @var string The name of the "exception" column.
     */
    public const EXCEPTION = 'exception';
    /**
     * @var string The name of the "failed at" column.
     */
    public const FAILED_AT = 'failed_at';
    /**
     * @var string The name of the "id" column.
     */
    public const ID = 'id';
    /**
     * @var string The name of the "payload" column.
     */
    public const PAYLOAD = 'payload';
    /**
     * @var string The name of the "queue" column.
     */
    public const QUEUE = 'queue';
    /**
     * @var string The name of the "uuid" column.
     */
    public const UUID = 'uuid';

    /**
     * @var string The name of the "failed jobs" table.
     */
    public const TABLE = 'failed_jobs';

    #endregion
}
