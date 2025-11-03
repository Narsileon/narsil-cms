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
     * Run the migrations.
     *
     * @return void
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
     * Reverse the migrations.
     *
     * @return void
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
     * Create the failed jobs table.
     *
     * @return void
     */
    private function createFailedJobsTable(): void
    {
        Schema::create(FailedJob::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(FailedJob::ID);
            $blueprint
                ->string(FailedJob::UUID)
                ->unique();
            $blueprint
                ->text(FailedJob::CONNECTION);
            $blueprint
                ->text(FailedJob::QUEUE);
            $blueprint
                ->longText(FailedJob::PAYLOAD);
            $blueprint
                ->longText(FailedJob::EXCEPTION);
            $blueprint
                ->timestamp(FailedJob::FAILED_AT)
                ->useCurrent();
        });
    }

    /**
     * Create the job batches table.
     *
     * @return void
     */
    private function createJobBatchesTable(): void
    {
        Schema::create(JobBatch::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->string(JobBatch::ID)
                ->primary();
            $blueprint
                ->string(JobBatch::NAME);
            $blueprint
                ->integer(JobBatch::TOTAL_JOBS);
            $blueprint
                ->integer(JobBatch::PENDING_JOBS);
            $blueprint
                ->integer(JobBatch::FAILED_JOBS);
            $blueprint
                ->longText(JobBatch::FAILED_JOB_IDS);
            $blueprint
                ->mediumText(JobBatch::OPTIONS)
                ->nullable();
            $blueprint
                ->integer(JobBatch::CANCELLED_AT)
                ->nullable();
            $blueprint
                ->integer(JobBatch::CREATED_AT);
            $blueprint
                ->integer(JobBatch::FINISHED_AT)
                ->nullable();
        });
    }

    /**
     * Create the jobs table.
     *
     * @return void
     */
    private function createJobsTable(): void
    {
        Schema::create(Job::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Job::ID);
            $blueprint
                ->string(Job::QUEUE)
                ->index();
            $blueprint
                ->longText(Job::PAYLOAD);
            $blueprint
                ->unsignedTinyInteger(Job::ATTEMPTS);
            $blueprint
                ->unsignedInteger(Job::RESERVED_AT)
                ->nullable();
            $blueprint
                ->unsignedInteger(Job::AVAILABLE_AT);
            $blueprint
                ->unsignedInteger(Job::CREATED_AT);
        });
    }

    #endregion
};
