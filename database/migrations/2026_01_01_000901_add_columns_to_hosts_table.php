<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Sites\Site;

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
        if (Schema::hasTable(Host::TABLE))
        {
            Schema::table(Host::TABLE, function (Blueprint $blueprint)
            {
                if (!Schema::hasColumn(Host::TABLE, Site::HEADER_ID))
                {
                    $blueprint
                        ->foreignId(Site::HEADER_ID)
                        ->nullable()
                        ->constrained(Header::TABLE, Header::ID)
                        ->nullOnDelete();
                }

                if (!Schema::hasColumn(Host::TABLE, Site::FOOTER_ID))
                {
                    $blueprint
                        ->foreignId(Site::FOOTER_ID)
                        ->nullable()
                        ->constrained(Footer::TABLE, Footer::ID)
                        ->nullOnDelete();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasTable(Host::TABLE))
        {
            Schema::table(Host::TABLE, function (Blueprint $blueprint)
            {
                if (Schema::hasColumn(Host::TABLE, Site::HEADER_ID))
                {
                    $blueprint->dropColumn(Site::HEADER_ID);
                }

                if (Schema::hasColumn(Host::TABLE, Site::FOOTER_ID))
                {
                    $blueprint->dropColumn(Site::FOOTER_ID);
                }
            });
        }
    }

    #endregion
};
