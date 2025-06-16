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
     * @var string
     */
    public const CONNECTION = 'connection';
    /**
     * @var string
     */
    public const EXCEPTION = 'exception';
    /**
     * @var string
     */
    public const FAILED_AT = 'failed_at';
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
    public const UUID = 'uuid';

    /**
     * @var string
     */
    public const TABLE = 'failed_jobs';

    #endregion
}
