<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Base\Models\User;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Globals\Header;

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
            if (!Schema::hasTable("$schema." . Header::TABLE))
            {
                $this->createHeadersTable($schema);
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
            Schema::dropIfExists("$schema." . Header::TABLE);
        };
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the headers table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createHeadersTable(string $schema): void
    {
        Schema::create("$schema." . Header::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Header::ID);
            $blueprint
                ->string(Header::SLUG)
                ->unique();
            $blueprint
                ->string(Header::LOGO)
                ->nullable();
            $blueprint
                ->timestamp(Header::CREATED_AT);
            $blueprint
                ->foreignId(Header::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Header::UPDATED_AT);
            $blueprint
                ->foreignId(Header::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    #endregion
};
