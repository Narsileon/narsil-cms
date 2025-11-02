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
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Models\Hosts\HostPage;
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
        if (!Schema::hasTable(Host::TABLE))
        {
            $this->createHostsTable();
        }
        if (!Schema::hasTable(HostLocale::TABLE))
        {
            $this->createHostLocalesTable();
        }
        if (!Schema::hasTable(HostLocaleLanguage::TABLE))
        {
            $this->createHostLocaleLanguagesTable();
        }
        if (!Schema::hasTable(HostPage::TABLE))
        {
            $this->createHostPagesTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(HostPage::TABLE);
        Schema::dropIfExists(HostLocaleLanguage::TABLE);
        Schema::dropIfExists(HostLocale::TABLE);
        Schema::dropIfExists(Host::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the host locale languages table.
     *
     * @return void
     */
    private function createHostLocaleLanguagesTable(): void
    {
        Schema::create(HostLocaleLanguage::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(HostLocaleLanguage::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(HostLocaleLanguage::LOCALE_UUID)
                ->nullable()
                ->constrained(HostLocale::TABLE, HostLocale::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->string(HostLocaleLanguage::LANGUAGE);
            $blueprint
                ->integer(HostLocaleLanguage::POSITION);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the host locales table.
     *
     * @return void
     */
    private function createHostLocalesTable(): void
    {
        Schema::create(HostLocale::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(HostLocale::UUID)
                ->primary();
            $blueprint
                ->foreignId(HostLocale::HOST_ID)
                ->nullable()
                ->constrained(Host::TABLE, Host::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(HostLocale::COUNTRY)
                ->default('default');
            $blueprint
                ->integer(HostLocale::POSITION)
                ->default(0);
            $blueprint
                ->string(HostLocale::PATTERN);
            $blueprint
                ->string(HostLocale::REGEX);
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
                ->foreignUuid(HostPage::HOST_LOCALE_UUID)
                ->nullable()
                ->constrained(HostLocale::TABLE, HostLocale::UUID)
                ->cascadeOnDelete();
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

    /**
     * Create the hosts table.
     *
     * @return void
     */
    private function createHostsTable(): void
    {
        Schema::create(Host::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Host::ID);
            $blueprint
                ->string(Host::HANDLE)
                ->unique();
            $blueprint
                ->jsonb(Host::NAME);
            $blueprint
                ->timestamp(Host::CREATED_AT);
            $blueprint
                ->foreignId(Host::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Host::UPDATED_AT);
            $blueprint
                ->foreignId(Host::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    #endregion
};
