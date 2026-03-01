<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Base\Models\User;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Configuration;

#endregion

return new class extends Migration
{
    use HasSchemas;

    #region PUBLIC METHODS

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            if (!Schema::hasTable("$schema." . Configuration::TABLE))
            {
                $this->createConfigurationsTable($schema);
            }
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            Schema::dropIfExists("$schema." . Configuration::TABLE);
        };
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the audit logs table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createConfigurationsTable(string $schema): void
    {
        Schema::create("$schema." . Configuration::TABLE, function (Blueprint $blueprint)
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
