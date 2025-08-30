<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Enums\Database\EventEnum;
use Narsil\Models\AuditLog;
use Narsil\Models\User;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable(AuditLog::TABLE))
        {
            $this->createAuditLogsTable();
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(AuditLog::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createAuditLogsTable(): void
    {
        Schema::create(AuditLog::TABLE, function (Blueprint $table)
        {
            $table
                ->uuid(AuditLog::UUID)
                ->primary();
            $table
                ->morphs(AuditLog::RELATION_MODEL);
            $table
                ->foreignId(AuditLog::USER_ID)
                ->nullable()
                ->constrained(User::TABLE, User::ID);
            $table
                ->enum(AuditLog::EVENT, EventEnum::values());
            $table
                ->json(AuditLog::OLD_VALUES)
                ->nullable();
            $table
                ->json(AuditLog::NEW_VALUES)
                ->nullable();
            $table
                ->timestamps();
        });
    }

    #endregion
};
