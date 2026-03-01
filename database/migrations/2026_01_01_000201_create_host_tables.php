<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Base\Models\User;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;

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
            if (!Schema::hasTable("$schema." . Host::TABLE))
            {
                $this->createHostsTable($schema);
            }
            if (!Schema::hasTable("$schema." . HostLocale::TABLE))
            {
                $this->createHostLocalesTable($schema);
            }
            if (!Schema::hasTable("$schema." . HostLocaleLanguage::TABLE))
            {
                $this->createHostLocaleLanguagesTable($schema);
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
            Schema::dropIfExists("$schema." . HostLocaleLanguage::TABLE);
            Schema::dropIfExists("$schema." . HostLocale::TABLE);
            Schema::dropIfExists("$schema." . Host::TABLE);
        };
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the host locale languages table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createHostLocaleLanguagesTable(string $schema): void
    {
        Schema::create("$schema." . HostLocaleLanguage::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(HostLocaleLanguage::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(HostLocaleLanguage::LOCALE_UUID)
                ->nullable()
                ->constrained("$schema." . HostLocale::TABLE, HostLocale::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->string(HostLocaleLanguage::LANGUAGE);
            $blueprint
                ->integer(HostLocaleLanguage::POSITION)
                ->default(0)
                ->index();
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the host locales table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createHostLocalesTable(string $schema): void
    {
        Schema::create("$schema." . HostLocale::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(HostLocale::UUID)
                ->primary();
            $blueprint
                ->foreignId(HostLocale::HOST_ID)
                ->nullable()
                ->constrained("$schema." . Host::TABLE, Host::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(HostLocale::COUNTRY)
                ->default('default');
            $blueprint
                ->integer(HostLocale::POSITION)
                ->default(0)
                ->index();
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
     * @param string $schema
     *
     * @return void
     */
    private function createHostsTable(string $schema): void
    {
        Schema::create("$schema." . Host::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Host::ID);
            $blueprint
                ->string(Host::HOSTNAME)
                ->unique();
            $blueprint
                ->jsonb(Host::LABEL);
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
