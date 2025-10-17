<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteNavigation;

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
        if (!Schema::hasTable(Site::TABLE))
        {
            $this->createSitesTable();
        }
        if (!Schema::hasTable(SiteNavigation::TABLE))
        {
            $this->createSiteNavigationsTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(SiteNavigation::TABLE);
        Schema::dropIfExists(Site::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the site navigations table.
     *
     * @return void
     */
    private function createSiteNavigationsTable(): void
    {
        Schema::create(SiteNavigation::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(SiteNavigation::ID);
            $blueprint
                ->foreignId(SiteNavigation::SITE_ID)
                ->constrained(Site::TABLE, Site::ID)
                ->cascadeOnDelete();
            $blueprint
                ->bigInteger(SiteNavigation::PARENT_ID)
                ->nullable();
            $blueprint
                ->bigInteger(SiteNavigation::LEFT_ID)
                ->nullable();
            $blueprint
                ->bigInteger(SiteNavigation::RIGHT_ID)
                ->nullable();
            $blueprint
                ->timestamps();
        });

        Schema::table(SiteNavigation::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->foreign(SiteNavigation::PARENT_ID)
                ->references(SiteNavigation::ID)
                ->on(SiteNavigation::TABLE)
                ->nullOnDelete();
            $blueprint
                ->foreign(SiteNavigation::LEFT_ID)
                ->references(SiteNavigation::ID)
                ->on(SiteNavigation::TABLE)
                ->nullOnDelete();
            $blueprint
                ->foreign(SiteNavigation::RIGHT_ID)
                ->references(SiteNavigation::ID)
                ->on(SiteNavigation::TABLE)
                ->nullOnDelete();
        });
    }

    /**
     * Create the sites table.
     *
     * @return void
     */
    private function createSitesTable(): void
    {
        Schema::create(Site::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Site::ID);
            $blueprint
                ->foreignId(Site::HOST_ID)
                ->constrained(Host::TABLE, Host::ID)
                ->cascadeOnDelete();
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
