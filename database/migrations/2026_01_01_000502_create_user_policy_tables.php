<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Policies\UserPermission;
use Narsil\Models\Policies\UserRole;
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
        if (!Schema::hasTable(UserRole::TABLE))
        {
            $this->createUserRoleTable();
        }
        if (!Schema::hasTable(UserPermission::TABLE))
        {
            $this->createUserPermissionTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(UserPermission::TABLE);
        Schema::dropIfExists(UserRole::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the user permissions table.
     *
     * @return void
     */
    private function createUserPermissionTable(): void
    {
        Schema::create(UserPermission::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(UserPermission::ID);
            $blueprint
                ->foreignId(UserPermission::USER_ID)
                ->constrained(User::TABLE, User::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(UserPermission::PERMISSION_ID)
                ->constrained(Permission::TABLE, Permission::ID)
                ->cascadeOnDelete();
        });
    }

    /**
     * Create the user roles table.
     *
     * @return void
     */
    private function createUserRoleTable(): void
    {
        Schema::create(UserRole::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(UserRole::ID);
            $blueprint
                ->foreignId(UserRole::USER_ID)
                ->constrained(User::TABLE, User::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(UserRole::ROLE_ID)
                ->constrained(Role::TABLE, Role::ID)
                ->cascadeOnDelete();
        });
    }

    #endregion
};
