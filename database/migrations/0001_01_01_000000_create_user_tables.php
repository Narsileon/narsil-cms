<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Narsil\Enums\Configuration\ColorEnum;
use Narsil\Enums\Configuration\ThemeEnum;
use Narsil\Models\User;
use Narsil\Models\Users\PasswordResetToken;
use Narsil\Models\Users\Session;
use Narsil\Models\Users\UserBookmark;
use Narsil\Models\Users\UserConfiguration;

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
        if (!Schema::hasTable(UserBookmark::TABLE))
        {
            $this->createUserBookmarksTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(UserBookmark::TABLE);
        Schema::dropIfExists(UserConfiguration::TABLE);
        Schema::dropIfExists(Session::TABLE);
        Schema::dropIfExists(PasswordResetToken::TABLE);
        Schema::dropIfExists(User::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the password reset tokens table.
     *
     * @return void
     */
    private function createPasswordResetTokensTable(): void
    {
        Schema::create(PasswordResetToken::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->string(PasswordResetToken::EMAIL)
                ->primary();
            $blueprint
                ->string(PasswordResetToken::TOKEN);
            $blueprint
                ->timestamp(PasswordResetToken::CREATED_AT)
                ->nullable();
        });
    }

    /**
     * Create the sessions table.
     *
     * @return void
     */
    private function createSessionsTable(): void
    {
        Schema::create(Session::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->string(Session::ID)
                ->primary();
            $blueprint
                ->foreignId(Session::USER_ID)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(Session::IP_ADDRESS, 45)
                ->nullable();
            $blueprint
                ->text(Session::USER_AGENT)
                ->nullable();
            $blueprint
                ->longText(Session::PAYLOAD);
            $blueprint
                ->integer(Session::LAST_ACTIVITY)
                ->index();
        });
    }

    /**
     * Create the user bookmarks table.
     *
     * @return void
     */
    private function createUserBookmarksTable(): void
    {
        Schema::create(UserBookmark::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(UserBookmark::ID);
            $blueprint
                ->foreignId(UserBookmark::USER_ID)
                ->constrained(User::TABLE, User::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(UserBookmark::NAME);
            $blueprint
                ->string(UserBookmark::URL);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the user configurations table.
     *
     * @return void
     */
    private function createUserConfigurationsTable(): void
    {
        Schema::create(UserConfiguration::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->foreignId(UserConfiguration::USER_ID)
                ->primary()
                ->constrained(User::TABLE, User::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(UserConfiguration::LANGUAGE)
                ->default(Config::get('app.locale'));
            $blueprint
                ->string(UserConfiguration::COLOR)
                ->default(ColorEnum::GRAY->value);
            $blueprint
                ->decimal(UserConfiguration::RADIUS, 3, 2)
                ->default(0.5);
            $blueprint
                ->string(UserConfiguration::THEME)
                ->default(ThemeEnum::SYSTEM->value);
            $blueprint
                ->jsonb(UserConfiguration::PREFERENCES)
                ->nullable();
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the users table.
     *
     * @return void
     */
    private function createUsersTable(): void
    {
        Schema::create(User::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(User::ID);
            $blueprint
                ->boolean(User::ENABLED)
                ->default(false)
                ->index();
            $blueprint
                ->string(User::LAST_NAME)
                ->nullable();
            $blueprint
                ->string(User::FIRST_NAME)
                ->nullable();
            $blueprint
                ->string(User::EMAIL)
                ->unique();
            $blueprint
                ->timestamp(User::EMAIL_VERIFIED_AT)
                ->nullable();
            $blueprint
                ->string(User::PASSWORD);
            $blueprint
                ->text(User::TWO_FACTOR_SECRET)
                ->nullable();
            $blueprint
                ->text(User::TWO_FACTOR_RECOVERY_CODES)
                ->nullable();
            $blueprint
                ->timestamp(User::TWO_FACTOR_CONFIRMED_AT)
                ->nullable();
            $blueprint
                ->rememberToken();
            $blueprint
                ->string(User::AVATAR)
                ->nullable();
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
