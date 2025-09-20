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
        Schema::create(Relation::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id();
            $blueprint
                ->string(Relation::OWNER_TABLE);
            $blueprint
                ->uuid(Relation::OWNER_UUID);
            $blueprint
                ->string(Relation::TARGET_TABLE);
            $blueprint
                ->uuid(Relation::TARGET_UUID);
        });
    }

    #endregion
};
