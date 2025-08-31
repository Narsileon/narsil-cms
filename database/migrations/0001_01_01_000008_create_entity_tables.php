<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\AuditLog;
use Narsil\Models\Entities\Relation;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function up(): void
    {
        if (!Schema::hasTable(Relation::TABLE))
        {
            $this->createRelationsTable();
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
    private function createRelationsTable(): void
    {
        Schema::create(Relation::TABLE, function (Blueprint $table)
        {
            $table
                ->id();
            $table
                ->string(Relation::OWNER_TABLE);
            $table
                ->uuid(Relation::OWNER_UUID);
            $table
                ->string(Relation::TARGET_TABLE);
            $table
                ->uuid(Relation::TARGET_UUID);
        });
    }

    #endregion
};
