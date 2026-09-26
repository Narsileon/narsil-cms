<?php

declare(strict_types=1);

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Cms\Models\Redirect;

#endregion

return new class() extends Migration
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Redirect::TABLE);
    }

    /**
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable(Redirect::TABLE))
        {
            $this->createRedirectsTable();
        }
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createRedirectsTable(): void
    {
        Schema::create(Redirect::TABLE, function (Blueprint $blueprint)
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
