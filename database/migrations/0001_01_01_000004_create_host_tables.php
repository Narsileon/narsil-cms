<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
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
                ->id(HostLocaleLanguage::ID);
            $blueprint
                ->foreignId(HostLocaleLanguage::LOCALE_ID)
                ->nullable()
                ->constrained(HostLocale::TABLE, HostLocale::ID)
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
                ->id(HostLocale::ID);
            $blueprint
                ->foreignId(HostLocale::HOST_ID)
                ->nullable()
                ->constrained(Host::TABLE, Host::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(HostLocale::COUNTRY)
                ->nullable();
            $blueprint
                ->integer(HostLocale::POSITION);
            $blueprint
                ->string(HostLocale::PATTERN);
            $blueprint
                ->string(HostLocale::REGEX);
            $blueprint
                ->timestamps();
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
                ->json(Host::NAME);
            $blueprint
                ->string(Host::HANDLE);
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
