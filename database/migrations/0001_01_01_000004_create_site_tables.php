<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteSubdomain;
use Narsil\Models\Sites\SiteSubdomainLanguage;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function up(): void
    {
        if (!Schema::hasTable(Site::TABLE))
        {
            $this->createSitesTable();
        }
        if (!Schema::hasTable(SiteSubdomain::TABLE))
        {
            $this->createSiteSubdomainsTable();
        }
        if (!Schema::hasTable(SiteSubdomainLanguage::TABLE))
        {
            $this->createSiteSubdomainLanguagesTable();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function down(): void
    {
        Schema::dropIfExists(SiteSubdomainLanguage::TABLE);
        Schema::dropIfExists(SiteSubdomain::TABLE);
        Schema::dropIfExists(Site::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createSiteSubdomainLanguagesTable(): void
    {
        Schema::create(SiteSubdomainLanguage::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(SiteSubdomainLanguage::ID);
            $blueprint
                ->foreignId(SiteSubdomainLanguage::SUBDOMAIN_ID)
                ->nullable()
                ->constrained(SiteSubdomain::TABLE, SiteSubdomain::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(SiteSubdomainLanguage::LANGUAGE);
            $blueprint
                ->integer(SiteSubdomainLanguage::POSITION);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createSiteSubdomainsTable(): void
    {
        Schema::create(SiteSubdomain::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(SiteSubdomain::ID);
            $blueprint
                ->foreignId(SiteSubdomain::SITE_ID)
                ->nullable()
                ->constrained(Site::TABLE, Site::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(SiteSubdomain::SUBDOMAIN);
            $blueprint
                ->integer(SiteSubdomain::POSITION);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createSitesTable(): void
    {
        Schema::create(Site::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Site::ID);
            $blueprint
                ->string(Site::NAME);
            $blueprint
                ->string(Site::DOMAIN);
            $blueprint
                ->string(Site::PATTERN);
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
