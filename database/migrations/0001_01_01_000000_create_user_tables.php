<?php

#region USE

use App\Models\PasswordResetToken;
use App\Models\Session;
use App\Models\User;
use App\Models\Users\UserConfiguration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        if (!Schema::hasTable(User::TABLE))
        {
            $this->createUsersTable();
        }

        if (!Schema::hasTable(PasswordResetToken::TABLE))
        {
            $this->createPasswordResetTokensTable();
        }

        if (!Schema::hasTable(Session::TABLE))
        {
            $this->createSessionsTable();
        }

        if (!Schema::hasTable(UserConfiguration::TABLE))
        {
            $this->createUserConfigurationsTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(UserConfiguration::TABLE);
        Schema::dropIfExists(Session::TABLE);
        Schema::dropIfExists(PasswordResetToken::TABLE);
        Schema::dropIfExists(User::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createPasswordResetTokensTable(): void
    {
        Schema::create(PasswordResetToken::TABLE, function (Blueprint $table)
        {
            $table
                ->string(PasswordResetToken::EMAIL)
                ->primary();
            $table
                ->string(PasswordResetToken::TOKEN);
            $table
                ->timestamp(PasswordResetToken::CREATED_AT)
                ->nullable();
        });
    }

    /**
     * @return void
     */
    private function createSessionsTable(): void
    {
        Schema::create(Session::TABLE, function (Blueprint $table)
        {
            $table
                ->string(Session::ID)
                ->primary();
            $table
                ->foreignId(Session::USER_ID)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->cascadeOnDelete();
            $table
                ->string(Session::IP_ADDRESS, 45)
                ->nullable();
            $table
                ->text(Session::USER_AGENT)
                ->nullable();
            $table
                ->longText(Session::PAYLOAD);
            $table
                ->integer(Session::LAST_ACTIVITY)
                ->index();
        });
    }

    /**
     * @return void
     */
    private function createUserConfigurationsTable(): void
    {
        Schema::create(UserConfiguration::TABLE, function (Blueprint $table)
        {
            $table
                ->foreignId(UserConfiguration::USER_ID)
                ->primary()
                ->constrained(User::TABLE, User::ID)
                ->cascadeOnDelete();
            $table
                ->string(UserConfiguration::LOCALE)
                ->default('en');
            $table
                ->string(UserConfiguration::COLOR)
                ->default('default');
            $table
                ->decimal(UserConfiguration::RADIUS, 3, 2)
                ->default(0.65);
            $table
                ->string(UserConfiguration::THEME)
                ->default('system');
            $table
                ->json(UserConfiguration::PREFERENCES)
                ->nullable();
            $table
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createUsersTable(): void
    {
        Schema::create(User::TABLE, function (Blueprint $table)
        {
            $table
                ->id(User::ID);
            $table
                ->boolean(User::ENABLED)
                ->default(false);
            $table
                ->string(User::LAST_NAME)
                ->nullable();
            $table
                ->string(User::FIRST_NAME)
                ->nullable();
            $table
                ->string(User::EMAIL)
                ->unique();
            $table
                ->timestamp(User::EMAIL_VERIFIED_AT)
                ->nullable();
            $table
                ->string(User::PASSWORD);
            $table
                ->text(User::TWO_FACTOR_SECRET)
                ->nullable();
            $table
                ->text(User::TWO_FACTOR_RECOVERY_CODES)
                ->nullable();
            $table
                ->timestamp(User::TWO_FACTOR_CONFIRMED_AT)
                ->nullable();
            $table
                ->rememberToken();
            $table
                ->timestamps();
        });
    }

    #endregion
};
