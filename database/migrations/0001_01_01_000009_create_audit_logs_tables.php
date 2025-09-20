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
        Schema::create(AuditLog::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(AuditLog::UUID)
                ->primary();
            $blueprint
                ->morphs(AuditLog::RELATION_MODEL);
            $blueprint
                ->foreignId(AuditLog::USER_ID)
                ->nullable()
                ->constrained(User::TABLE, User::ID);
            $blueprint
                ->enum(AuditLog::EVENT, EventEnum::values());
            $blueprint
                ->json(AuditLog::OLD_VALUES)
                ->nullable();
            $blueprint
                ->json(AuditLog::NEW_VALUES)
                ->nullable();
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
