<?php

namespace Narsil\Models\Jobs;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
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
     * @var string The name of the "cancelled at" column.
     */
    final public const CANCELLED_AT = 'cancelled_at';
    /**
     * @var string The name of the "failed job ids" column.
     */
    final public const FAILED_JOB_IDS = 'failed_job_ids';
    /**
     * @var string The name of the "failed jobs" column.
     */
    final public const FAILED_JOBS = 'failed_jobs';
    /**
     * @var string The name of the "finished at" column.
     */
    final public const FINISHED_AT = 'finished_at';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "name" column.
     */
    final public const NAME = 'name';
    /**
     * @var string The name of the "options" column.
     */
    final public const OPTIONS = 'options';
    /**
     * @var string The name of the "pending jobs" column.
     */
    final public const PENDING_JOBS = 'pending_jobs';
    /**
     * @var string The name of the "total jobs" column.
     */
    final public const TOTAL_JOBS = 'total_jobs';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'job_batches';

    #endregion
}
