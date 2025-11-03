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
        if (!Schema::hasTable(Role::TABLE))
        {
            $this->createRolesTable();
        }
        if (!Schema::hasTable(RolePermission::TABLE))
        {
            $this->createRolePermissionTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(RolePermission::TABLE);
        Schema::dropIfExists(Role::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the roles table.
     *
     * @return void
     */
    private function createRolesTable(): void
    {
        Schema::create(Role::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Role::ID);
            $blueprint
                ->string(Role::HANDLE)
                ->unique();
            $blueprint
                ->jsonb(Role::NAME);
            $blueprint
                ->timestamp(Role::CREATED_AT);
            $blueprint
                ->foreignId(Role::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Role::UPDATED_AT);
            $blueprint
                ->foreignId(Role::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    /**
     * Create the role permissions table.
     *
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
        });
    }

    #endregion
};
