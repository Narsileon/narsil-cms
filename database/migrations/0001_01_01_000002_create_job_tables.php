<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Jobs\FailedJob;
use Narsil\Models\Jobs\Job;
use Narsil\Models\Jobs\JobBatch;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function up(): void
    {
        if (!Schema::hasTable(Job::TABLE))
        {
            $this->createJobsTable();
        }
        if (!Schema::hasTable(JobBatch::TABLE))
        {
            $this->createJobBatchesTable();
        }
        if (!Schema::hasTable(FailedJob::TABLE))
        {
            $this->createFailedJobsTable();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function down(): void
    {
        Schema::dropIfExists(FailedJob::TABLE);
        Schema::dropIfExists(JobBatch::TABLE);
        Schema::dropIfExists(Job::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createFailedJobsTable(): void
    {
        Schema::create(FailedJob::TABLE, function (Blueprint $table)
        {
            $table
                ->id(FailedJob::ID);
            $table
                ->string(FailedJob::UUID)
                ->unique();
            $table
                ->text(FailedJob::CONNECTION);
            $table
                ->text(FailedJob::QUEUE);
            $table
                ->longText(FailedJob::PAYLOAD);
            $table
                ->longText(FailedJob::EXCEPTION);
            $table
                ->timestamp(FailedJob::FAILED_AT)
                ->useCurrent();
        });
    }

    /**
     * @return void
     */
    private function createJobBatchesTable(): void
    {
        Schema::create(JobBatch::TABLE, function (Blueprint $table)
        {
            $table
                ->string(JobBatch::ID)
                ->primary();
            $table
                ->string(JobBatch::NAME);
            $table
                ->integer(JobBatch::TOTAL_JOBS);
            $table
                ->integer(JobBatch::PENDING_JOBS);
            $table
                ->integer(JobBatch::FAILED_JOBS);
            $table
                ->longText(JobBatch::FAILED_JOB_IDS);
            $table
                ->mediumText(JobBatch::OPTIONS)
                ->nullable();
            $table
                ->integer(JobBatch::CANCELLED_AT)
                ->nullable();
            $table
                ->integer(JobBatch::CREATED_AT);
            $table
                ->integer(JobBatch::FINISHED_AT)
                ->nullable();
        });
    }


    /**
     * @return void
     */
    private function createJobsTable(): void
    {
        Schema::create(Job::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Job::ID);
            $table
                ->string(Job::QUEUE)
                ->index();
            $table
                ->longText(Job::PAYLOAD);
            $table
                ->unsignedTinyInteger(Job::ATTEMPTS);
            $table
                ->unsignedInteger(Job::RESERVED_AT)
                ->nullable();
            $table
                ->unsignedInteger(Job::AVAILABLE_AT);
            $table
                ->unsignedInteger(Job::CREATED_AT);
        });
    }

    #endregion
};
