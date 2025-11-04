<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Enums\SEO\ChangeFreqEnum;
use Narsil\Enums\SEO\OpenGraphTypeEnum;
use Narsil\Enums\SEO\RobotsEnum;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostPage;
use Narsil\Models\Hosts\HostPageOverride;

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
        if (!Schema::hasTable(HostPage::TABLE))
        {
            $this->createHostPagesTable();
        }
        if (!Schema::hasTable(HostPageOverride::TABLE))
        {
            $this->createHostPageOverridesTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(HostPageOverride::TABLE);
        Schema::dropIfExists(HostPage::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the host page overrides table.
     *
     * @return void
     */
    private function createHostPageOverridesTable(): void
    {
        Schema::create(HostPageOverride::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(HostPageOverride::ID);
            $blueprint
                ->foreignId(HostPageOverride::HOST_PAGE_ID)
                ->constrained(HostPage::TABLE, HostPage::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(HostPageOverride::COUNTRY)
                ->default('default');
            $blueprint
                ->foreignId(HostPageOverride::PARENT_ID)
                ->nullable()
                ->constrained(HostPage::TABLE, HostPage::ID)
                ->nullOnDelete();
            $blueprint
                ->foreignId(HostPageOverride::LEFT_ID)
                ->nullable()
                ->constrained(HostPage::TABLE, HostPage::ID)
                ->nullOnDelete();
            $blueprint
                ->foreignId(HostPageOverride::RIGHT_ID)
                ->nullable()
                ->constrained(HostPage::TABLE, HostPage::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the host pages table.
     *
     * @return void
     */
    private function createHostPagesTable(): void
    {
        Schema::create(HostPage::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(HostPage::ID);
            $blueprint
                ->foreignId(HostPage::HOST_ID)
                ->constrained(Host::TABLE, Host::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(HostPage::COUNTRY)
                ->default('default');
            $blueprint
                ->bigInteger(HostPage::PARENT_ID)
                ->nullable();
            $blueprint
                ->bigInteger(HostPage::LEFT_ID)
                ->nullable();
            $blueprint
                ->bigInteger(HostPage::RIGHT_ID)
                ->nullable();
            $blueprint
                ->jsonb(HostPage::TITLE)
                ->nullable();
            $blueprint
                ->jsonb(HostPage::META_DESCRIPTION)
                ->nullable();
            $blueprint
                ->enum(HostPage::OPEN_GRAPH_TYPE, OpenGraphTypeEnum::values())
                ->default(OpenGraphTypeEnum::WEBSITE->value);
            $blueprint
                ->jsonb(HostPage::OPEN_GRAPH_TITLE)
                ->nullable();
            $blueprint
                ->jsonb(HostPage::OPEN_GRAPH_DESCRIPTION)
                ->nullable();
            $blueprint
                ->string(HostPage::OPEN_GRAPH_IMAGE)
                ->nullable();
            $blueprint
                ->enum(HostPage::ROBOTS, RobotsEnum::values())
                ->default(RobotsEnum::ALL->value);
            $blueprint
                ->enum(HostPage::CHANGE_FREQ, ChangeFreqEnum::values())
                ->default(ChangeFreqEnum::NEVER->value);
            $blueprint
                ->decimal(HostPage::PRIORITY, 3, 2)
                ->default(1.0);
            $blueprint
                ->timestamps();
        });

        Schema::table(HostPage::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->foreign(HostPage::PARENT_ID)
                ->references(HostPage::ID)
                ->on(HostPage::TABLE)
                ->nullOnDelete();
            $blueprint
                ->foreign(HostPage::LEFT_ID)
                ->references(HostPage::ID)
                ->on(HostPage::TABLE)
                ->nullOnDelete();
            $blueprint
                ->foreign(HostPage::RIGHT_ID)
                ->references(HostPage::ID)
                ->on(HostPage::TABLE)
                ->nullOnDelete();
        });
    }

    #endregion
};
