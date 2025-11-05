<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Globals\Footer;
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
        if (!Schema::hasTable(Footer::TABLE))
        {
            $this->createFootersTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Footer::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the footers table.
     *
     * @return void
     */
    private function createFootersTable(): void
    {
        Schema::create(Footer::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Footer::ID);
            $blueprint
                ->timestamp(Footer::CREATED_AT);
            $blueprint
                ->foreignId(Footer::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Footer::UPDATED_AT);
            $blueprint
                ->foreignId(Footer::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    #endregion
};
