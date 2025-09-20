<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Policies\RolePermission;
use Narsil\Models\Policies\UserPermission;
use Narsil\Models\Policies\UserRole;
use Narsil\Models\User;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function up(): void
    {
        if (!Schema::hasTable(Role::TABLE))
        {
            $this->createRolesTable();
        }
        if (!Schema::hasTable(Permission::TABLE))
        {
            $this->createPermissionsTable();
        }
        if (!Schema::hasTable(RolePermission::TABLE))
        {
            $this->createRolePermissionTable();
        }
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
     * {@inheritDoc}
     */
    public function down(): void
    {
        Schema::dropIfExists(UserPermission::TABLE);
        Schema::dropIfExists(UserRole::TABLE);
        Schema::dropIfExists(RolePermission::TABLE);
        Schema::dropIfExists(Permission::TABLE);
        Schema::dropIfExists(Role::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
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

    /**
     * @return void
     */
    private function createRolesTable(): void
    {
        Schema::create(Role::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Role::ID);
            $blueprint
                ->string(Role::NAME);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createRolePermissionTable(): void
    {
        Schema::create(RolePermission::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(RolePermission::ID);
            $blueprint
                ->foreignId(RolePermission::ROLE_ID)
                ->constrained(Role::TABLE, Role::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(RolePermission::PERMISSION_ID)
                ->constrained(Permission::TABLE, Permission::ID)
                ->cascadeOnDelete();
            $blueprint
                ->timestamps();
        });
    }

    /**
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
            $blueprint
                ->timestamps();
        });
    }

    /**
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
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
