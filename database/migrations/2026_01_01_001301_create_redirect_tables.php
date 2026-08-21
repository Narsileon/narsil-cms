<?php

declare(strict_types=1);

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Redirect;

#endregion

return new class extends Migration
{
    use HasSchemas;

    #region PUBLIC METHODS

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            Schema::dropIfExists("$schema." . Redirect::TABLE);
        }
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            if (!Schema::hasTable("$schema." . Redirect::TABLE))
            {
                $this->createRedirectsTable($schema);
            }
        }
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the redirects table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createRedirectsTable(string $schema): void
    {
        Schema::create("$schema." . Redirect::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Redirect::ID);
            $blueprint
                ->string(Redirect::URL_SOURCE)
                ->unique();
            $blueprint
                ->string(Redirect::URL_DESTINATION);
            $blueprint
                ->unsignedSmallInteger(Redirect::STATUS_CODE)
                ->default(301);
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
