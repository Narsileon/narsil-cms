<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteGroup;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function up(): void
    {
        if (!Schema::hasTable(SiteGroup::TABLE))
        {
            $this->createSiteGroupsTable();
        }
        if (!Schema::hasTable(Site::TABLE))
        {
            $this->createSitesTable();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function down(): void
    {
        Schema::dropIfExists(Site::TABLE);
        Schema::dropIfExists(SiteGroup::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createSiteGroupsTable(): void
    {
        Schema::create(SiteGroup::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(SiteGroup::ID);
            $blueprint
                ->string(SiteGroup::NAME);
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
                ->foreignId(Site::GROUP_ID)
                ->nullable()
                ->constrained(SiteGroup::TABLE, SiteGroup::ID)
                ->cascadeOnDelete();
            $blueprint
                ->boolean(Site::ENABLED)
                ->default(true);
            $blueprint
                ->string(Site::NAME);
            $blueprint
                ->string(Site::HANDLE);
            $blueprint
                ->string(Site::LANGUAGE);
            $blueprint
                ->boolean(Site::PRIMARY);
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
