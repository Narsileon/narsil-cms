<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Narsil\Cms\Models\User;
use Narsil\Cms\Models\Users\UserConfiguration;
use Narsil\Ui\Enums\ColorEnum;
use Narsil\Ui\Enums\ThemeEnum;

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
    }

    #endregion

    #region PRIVATE METHODS

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
                ->uuid(UserConfiguration::UUID)
                ->primary();
            $blueprint
                ->foreignId(UserConfiguration::USER_ID)
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
                ->default(0.25);
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

    #endregion
};
