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
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable(Relation::TABLE))
        {
            $this->createRelationsTable();
        }
    }

    /**
     * Reverse the migrations.
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
     * Create the relations table.
     *
     * @return void
     */
    private function createRelationsTable(): void
    {
        Schema::create(Relation::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id();
            $blueprint
                ->uuid(Relation::OWNER_UUID);
            $blueprint
                ->string(Relation::OWNER_TABLE);
            $blueprint
                ->bigInteger(Relation::OWNER_ID);
            $blueprint
                ->string(Relation::TARGET_TABLE);
            $blueprint
                ->bigInteger(Relation::TARGET_ID);
            $blueprint
                ->softDeletes(Relation::DELETED_AT)
                ->index();
        });
    }

    #endregion
};
