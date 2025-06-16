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
class JobBatch extends Model
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
    public const CANCELLED_AT = 'cancelled_at';
    /**
     * @var string
     */
    public const FAILED_JOB_IDS = 'failed_job_ids';
    /**
     * @var string
     */
    public const FAILED_JOBS = 'failed_jobs';
    /**
     * @var string
     */
    public const FINISHED_AT = 'finished_at';
    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const NAME = 'name';
    /**
     * @var string
     */
    public const OPTIONS = 'options';
    /**
     * @var string
     */
    public const PENDING_JOBS = 'pending_jobs';
    /**
     * @var string
     */
    public const TOTAL_JOBS = 'total_jobs';

    /**
     * @var string
     */
    public const TABLE = 'job_batches';

    #endregion
}
