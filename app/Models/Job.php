<?php

namespace App\Models;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class Job extends Model
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
     * @var string The name of the "attempts" column.
     */
    public const ATTEMPTS = 'attempts';
    /**
     * @var string The name of the "available at" column.
     */
    public const AVAILABLE_AT = 'available_at';
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
     * @var string The name of the "reserved at" column.
     */
    public const RESERVED_AT = 'reserved_at';

    /**
     * @var string The name of the "jobs" table.
     */
    public const TABLE = 'jobs';

    #endregion
}
