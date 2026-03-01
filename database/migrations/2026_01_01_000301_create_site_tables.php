<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Enums\SEO\ChangeFreqEnum;
use Narsil\Cms\Enums\SEO\OpenGraphTypeEnum;
use Narsil\Cms\Enums\SEO\RobotsEnum;
use Narsil\Cms\Enums\SitePageAdapterEnum;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\SitePageEntity;
use Narsil\Cms\Models\Sites\SitePageOverride;
use Narsil\Cms\Models\Sites\SiteUrl;

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
            if (!Schema::hasTable("$schema." . SitePage::TABLE))
            {
                $this->createSitePagesTable($schema);
            }
            if (!Schema::hasTable("$schema." . SitePageOverride::TABLE))
            {
                $this->createSitePageOverridesTable($schema);
            }
            if (!Schema::hasTable("$schema." . SitePageEntity::TABLE))
            {
                $this->createSitePageEntityTable($schema);
            }
            if (!Schema::hasTable("$schema." . SiteUrl::TABLE))
            {
                $this->createSiteUrlsTable($schema);
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
            Schema::dropIfExists("$schema." . SiteUrl::TABLE);
            Schema::dropIfExists("$schema." . SitePageEntity::TABLE);
            Schema::dropIfExists("$schema." . SitePageOverride::TABLE);
            Schema::dropIfExists("$schema." . SitePage::TABLE);
        };
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the site page entity table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createSitePageEntityTable(string $schema): void
    {
        Schema::create("$schema." . SitePageEntity::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(SitePageEntity::UUID)
                ->primary();
            $blueprint
                ->foreignId(SitePageEntity::SITE_PAGE_ID)
                ->constrained("$schema." . SitePage::TABLE, SitePage::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(SitePageEntity::LANGUAGE);
            $blueprint
                ->morphs(SitePageEntity::RELATION_TARGET);
        });
    }

    /**
     * Create the site page overrides table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createSitePageOverridesTable(string $schema): void
    {
        Schema::create("$schema." . SitePageOverride::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(SitePageOverride::UUID)
                ->primary();
            $blueprint
                ->foreignId(SitePageOverride::SITE_PAGE_ID)
                ->constrained("$schema." . SitePage::TABLE, SitePage::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(SitePageOverride::COUNTRY)
                ->default('default');
            $blueprint
                ->foreignId(SitePageOverride::PARENT_ID)
                ->nullable()
                ->constrained("$schema." . SitePage::TABLE, SitePage::ID)
                ->nullOnDelete();
            $blueprint
                ->foreignId(SitePageOverride::LEFT_ID)
                ->nullable()
                ->constrained("$schema." . SitePage::TABLE, SitePage::ID)
                ->nullOnDelete();
            $blueprint
                ->foreignId(SitePageOverride::RIGHT_ID)
                ->nullable()
                ->constrained("$schema." . SitePage::TABLE, SitePage::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the site pages table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createSitePagesTable(string $schema): void
    {
        Schema::create("$schema." . SitePage::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->id(SitePage::ID);
            $blueprint
                ->foreignId(SitePage::SITE_ID)
                ->constrained("$schema." . Site::TABLE, Site::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(SitePage::COUNTRY)
                ->default('default');
            $blueprint
                ->bigInteger(SitePage::PARENT_ID)
                ->nullable();
            $blueprint
                ->bigInteger(SitePage::LEFT_ID)
                ->nullable();
            $blueprint
                ->bigInteger(SitePage::RIGHT_ID)
                ->nullable();
            $blueprint
                ->jsonb(SitePage::TITLE);
            $blueprint
                ->jsonb(SitePage::SLUG);
            $blueprint
                ->enum(SitePage::ADAPTER, SitePageAdapterEnum::values())
                ->default(SitePageAdapterEnum::ENTITY->value);
            $blueprint
                ->string(SitePage::COLLECTION)
                ->nullable();
            $blueprint
                ->jsonb(SitePage::META_DESCRIPTION)
                ->nullable();
            $blueprint
                ->enum(SitePage::OPEN_GRAPH_TYPE, OpenGraphTypeEnum::values())
                ->default(OpenGraphTypeEnum::WEBSITE->value);
            $blueprint
                ->jsonb(SitePage::OPEN_GRAPH_TITLE)
                ->nullable();
            $blueprint
                ->jsonb(SitePage::OPEN_GRAPH_DESCRIPTION)
                ->nullable();
            $blueprint
                ->string(SitePage::OPEN_GRAPH_IMAGE)
                ->nullable();
            $blueprint
                ->enum(SitePage::ROBOTS, RobotsEnum::values())
                ->default(RobotsEnum::ALL->value);
            $blueprint
                ->enum(SitePage::CHANGE_FREQ, ChangeFreqEnum::values())
                ->default(ChangeFreqEnum::NEVER->value);
            $blueprint
                ->decimal(SitePage::PRIORITY, 3, 2)
                ->default(1.0);
            $blueprint
                ->boolean(SitePage::SHOW_IN_MENU)
                ->default(true);
            $blueprint
                ->timestamps();
        });

        Schema::table("$schema." . SitePage::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->foreign(SitePage::PARENT_ID)
                ->references(SitePage::ID)
                ->on("$schema." . SitePage::TABLE)
                ->nullOnDelete();
            $blueprint
                ->foreign(SitePage::LEFT_ID)
                ->references(SitePage::ID)
                ->on("$schema." . SitePage::TABLE)
                ->nullOnDelete();
            $blueprint
                ->foreign(SitePage::RIGHT_ID)
                ->references(SitePage::ID)
                ->on("$schema." . SitePage::TABLE)
                ->nullOnDelete();
        });
    }

    /**
     * Create the site urls table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createSiteUrlsTable(string $schema): void
    {
        Schema::create("$schema." . SiteUrl::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(SiteUrl::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(SiteUrl::HOST_LOCALE_LANGUAGE_UUID)
                ->constrained("$schema." . HostLocaleLanguage::TABLE, HostLocaleLanguage::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(SiteUrl::PAGE_ID)
                ->constrained("$schema." . SitePage::TABLE, SitePage::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(SiteUrl::URL)
                ->index();
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
