<?php

namespace Narsil\Models\Jobs;

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
    final public const ATTEMPTS = 'attempts';
    /**
     * @var string The name of the "available at" column.
     */
    final public const AVAILABLE_AT = 'available_at';
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
     * @var string The name of the "reserved at" column.
     */
    final public const RESERVED_AT = 'reserved_at';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'jobs';

    #endregion
}
