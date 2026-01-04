<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Enums\SEO\ChangeFreqEnum;
use Narsil\Enums\SEO\OpenGraphTypeEnum;
use Narsil\Enums\SEO\RobotsEnum;
use Narsil\Enums\SitePageAdapterEnum;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Sites\SitePageEntity;
use Narsil\Models\Sites\SitePageOverride;
use Narsil\Models\Sites\SiteUrl;

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
        if (!Schema::hasTable(SitePage::TABLE))
        {
            $this->createSitePagesTable();
        }
        if (!Schema::hasTable(SitePageOverride::TABLE))
        {
            $this->createSitePageOverridesTable();
        }
        if (!Schema::hasTable(SitePageEntity::TABLE))
        {
            $this->createSitePageEntityTable();
        }
        if (!Schema::hasTable(SiteUrl::TABLE))
        {
            $this->createSiteUrlsTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(SiteUrl::TABLE);
        Schema::dropIfExists(SitePageEntity::TABLE);
        Schema::dropIfExists(SitePageOverride::TABLE);
        Schema::dropIfExists(SitePage::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the site page entity table.
     *
     * @return void
     */
    private function createSitePageEntityTable(): void
    {
        Schema::create(SitePageEntity::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(SitePageEntity::UUID)
                ->primary();
            $blueprint
                ->foreignId(SitePageEntity::SITE_PAGE_ID)
                ->constrained(SitePage::TABLE, SitePage::ID)
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
     * @return void
     */
    private function createSitePageOverridesTable(): void
    {
        Schema::create(SitePageOverride::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(SitePageOverride::UUID)
                ->primary();
            $blueprint
                ->foreignId(SitePageOverride::SITE_PAGE_ID)
                ->constrained(SitePage::TABLE, SitePage::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(SitePageOverride::COUNTRY)
                ->default('default');
            $blueprint
                ->foreignId(SitePageOverride::PARENT_ID)
                ->nullable()
                ->constrained(SitePage::TABLE, SitePage::ID)
                ->nullOnDelete();
            $blueprint
                ->foreignId(SitePageOverride::LEFT_ID)
                ->nullable()
                ->constrained(SitePage::TABLE, SitePage::ID)
                ->nullOnDelete();
            $blueprint
                ->foreignId(SitePageOverride::RIGHT_ID)
                ->nullable()
                ->constrained(SitePage::TABLE, SitePage::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the site pages table.
     *
     * @return void
     */
    private function createSitePagesTable(): void
    {
        Schema::create(SitePage::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(SitePage::ID);
            $blueprint
                ->foreignId(SitePage::SITE_ID)
                ->constrained(Site::TABLE, Site::ID)
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
                ->jsonb(SitePage::ENTITY)
                ->nullable();
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

        Schema::table(SitePage::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->foreign(SitePage::PARENT_ID)
                ->references(SitePage::ID)
                ->on(SitePage::TABLE)
                ->nullOnDelete();
            $blueprint
                ->foreign(SitePage::LEFT_ID)
                ->references(SitePage::ID)
                ->on(SitePage::TABLE)
                ->nullOnDelete();
            $blueprint
                ->foreign(SitePage::RIGHT_ID)
                ->references(SitePage::ID)
                ->on(SitePage::TABLE)
                ->nullOnDelete();
        });
    }

    /**
     * Create the site urls table.
     *
     * @return void
     */
    private function createSiteUrlsTable(): void
    {
        Schema::create(SiteUrl::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(SiteUrl::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(SiteUrl::HOST_LOCALE_LANGUAGE_UUID)
                ->constrained(HostLocaleLanguage::TABLE, HostLocaleLanguage::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(SiteUrl::PAGE_ID)
                ->constrained(SitePage::TABLE, SitePage::ID)
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
