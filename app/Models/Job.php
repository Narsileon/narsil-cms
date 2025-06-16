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
     * @var string
     */
    public const ATTEMPTS = 'attempts';
    /**
     * @var string
     */
    public const AVAILABLE_AT = 'available_at';
    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const PAYLOAD = 'payload';
    /**
     * @var string
     */
    public const QUEUE = 'queue';
    /**
     * @var string
     */
    public const RESERVED_AT = 'reserved_at';

    /**
     * @var string
     */
    public const TABLE = 'jobs';

    #endregion
}
