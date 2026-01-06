<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Configuration;
use Narsil\Models\User;

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
        if (!Schema::hasTable(Configuration::TABLE))
        {
            $this->createConfigurationsTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Configuration::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the audit logs table.
     *
     * @return void
     */
    private function createConfigurationsTable(): void
    {
        Schema::create(Configuration::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Configuration::ID);
            $blueprint
                ->string(Configuration::DEFAULT_LANGUAGE)
                ->nullable();
            $blueprint
                ->timestamp(Configuration::CREATED_AT);
            $blueprint
                ->foreignId(Configuration::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Configuration::UPDATED_AT);
            $blueprint
                ->foreignId(Configuration::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    #endregion
};
