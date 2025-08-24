<?php

namespace Narsil\Models\Jobs;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class JobBatch extends Model
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
    final public const TABLE = 'job_batches';

    #region • COLUMNS

    /**
     * The name of the "cancelled at" column.
     *
     * @var string
     */
    final public const CANCELLED_AT = 'cancelled_at';

    /**
     * The name of the "failed job ids" column.
     *
     * @var string
     */
    final public const FAILED_JOB_IDS = 'failed_job_ids';

    /**
     * The name of the "failed jobs" column.
     *
     * @var string
     */
    final public const FAILED_JOBS = 'failed_jobs';

    /**
     * The name of the "finished at" column.
     * s
     * @var string
     */
    final public const FINISHED_AT = 'finished_at';

    /**
     * The name of the "ID" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "name" column.
     *
     * @var string
     */
    final public const NAME = 'name';

    /**
     * The name of the "options" column.
     *
     * @var string
     */
    final public const OPTIONS = 'options';

    /**
     * The name of the "pending jobs" column.
     *
     * @var string
     */
    final public const PENDING_JOBS = 'pending_jobs';

    /**
     * The name of the "total jobs" column.
     *
     * @var string
     */
    final public const TOTAL_JOBS = 'total_jobs';

    #endregion

    #endregion
}
