<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Policies\RolePermission;
use Narsil\Models\User;

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
        if (!Schema::hasTable(Permission::TABLE))
        {
            $this->createPermissionsTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Permission::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the permissions table.
     *
     * @return void
     */
    private function createPermissionsTable(): void
    {
        Schema::create(Permission::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Permission::ID);
            $blueprint
                ->string(PERMISSION::NAME);
            $blueprint
                ->string(Permission::CATEGORY);
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
