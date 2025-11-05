<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Globals\Header;
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
        if (!Schema::hasTable(Header::TABLE))
        {
            $this->createHeadersTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Header::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the headers table.
     *
     * @return void
     */
    private function createHeadersTable(): void
    {
        Schema::create(Header::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Header::ID);
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
