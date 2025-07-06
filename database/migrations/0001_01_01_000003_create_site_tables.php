<?php

#region USE

use App\Models\Site;
use App\Models\SiteGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
     * Reverse the migrations.
     *
     * @return void
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
        Schema::create(SiteGroup::TABLE, function (Blueprint $table)
        {
            $table
                ->id(SiteGroup::ID);
            $table
                ->string(SiteGroup::NAME);
            $table
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createSitesTable(): void
    {
        Schema::create(Site::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Site::ID);
            $table
                ->foreignId(Site::GROUP_ID)
                ->nullable()
                ->constrained(SiteGroup::TABLE, SiteGroup::ID)
                ->cascadeOnDelete();
            $table
                ->boolean(Site::ENABLED)
                ->default(true);
            $table
                ->string(Site::NAME);
            $table
                ->string(Site::HANDLE);
            $table
                ->string(Site::LANGUAGE);
            $table
                ->boolean(Site::PRIMARY);
            $table
                ->timestamps();
        });
    }

    #endregion
};
