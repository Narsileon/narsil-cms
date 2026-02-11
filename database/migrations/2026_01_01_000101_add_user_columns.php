<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Cms\Models\User;

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
        $this->alterUsersTable();
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Alter the users table.
     *
     * @return void
     */
    private function alterUsersTable(): void
    {
        Schema::table(User::TABLE, function (Blueprint $blueprint)
        {
            if (!Schema::hasColumn(User::TABLE, User::AVATAR))
            {
                $blueprint
                    ->string(User::AVATAR)
                    ->nullable()
                    ->after(User::REMEMBER_TOKEN);
            }

            if (!Schema::hasColumn(User::TABLE, User::CREATED_BY))
            {
                $blueprint
                    ->foreignId(User::CREATED_BY)
                    ->nullable()
                    ->constrained(User::TABLE, User::ID)
                    ->nullOnDelete()
                    ->after(User::CREATED_AT);
            }

            if (!Schema::hasColumn(User::TABLE, User::UPDATED_BY))
            {
                $blueprint
                    ->foreignId(User::UPDATED_BY)
                    ->nullable()
                    ->constrained(User::TABLE, User::ID)
                    ->nullOnDelete()
                    ->after(User::UPDATED_AT);
            }
        });
    }

    #endregion
};
