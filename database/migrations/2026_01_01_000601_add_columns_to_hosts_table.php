<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Sites\Site;

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
            if (Schema::hasTable("$schema." . Host::TABLE))
            {
                Schema::table("$schema." . Host::TABLE, function (Blueprint $blueprint) use ($schema)
                {
                    if (!Schema::hasColumn("$schema." . Host::TABLE, Site::HEADER_ID))
                    {
                        $blueprint
                            ->foreignId(Site::HEADER_ID)
                            ->nullable()
                            ->constrained("$schema." . Header::TABLE, Header::ID)
                            ->nullOnDelete();
                    }

                    if (!Schema::hasColumn("$schema." . Host::TABLE, Site::FOOTER_ID))
                    {
                        $blueprint
                            ->foreignId(Site::FOOTER_ID)
                            ->nullable()
                            ->constrained("$schema." . Footer::TABLE, Footer::ID)
                            ->nullOnDelete();
                    }
                });
            }
        }
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
            if (Schema::hasTable("$schema." . Host::TABLE))
            {
                Schema::table("$schema." . Host::TABLE, function (Blueprint $blueprint) use ($schema)
                {
                    if (Schema::hasColumn("$schema." . Host::TABLE, Site::HEADER_ID))
                    {
                        $blueprint->dropColumn(Site::HEADER_ID);
                    }

                    if (Schema::hasColumn("$schema." . Host::TABLE, Site::FOOTER_ID))
                    {
                        $blueprint->dropColumn(Site::FOOTER_ID);
                    }
                });
            }
        }
    }

    #endregion
};
