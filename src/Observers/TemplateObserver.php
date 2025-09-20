<?php

namespace Narsil\Observers;

#region USE

use Narsil\Database\Migrations\CollectionMigration;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Elements\Template;
use Narsil\Models\Policies\Permission;
use Narsil\Services\GraphQLService;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TemplateObserver
{
    #region PUBLIC METHODS

    /**
     * @param Template $template
     *
     * @return void
     */
    public function created(Template $template): void
    {
        $table = $template->{Template::HANDLE};

        new CollectionMigration($table)->up();

        GraphQLService::generateTemplatesSchema();

        $this->createPermissions($table);
    }

    /**
     * @param Template $template
     *
     * @return void
     */
    public function deleted(Template $template): void
    {
        $table = $template->{Template::HANDLE};

        new CollectionMigration($table)->down();

        GraphQLService::generateTemplatesSchema();
    }

    #endregion

    #region PROTECTED METHODS

    protected function createPermissions(string $handle): void
    {
        $permissions = [
            PermissionEnum::VIEW->value,
            PermissionEnum::CREATE->value,
            PermissionEnum::UPDATE->value,
            PermissionEnum::DELETE->value,
        ];

        foreach ($permissions as $permission)
        {
            $key = $handle . '_' . $permission;

            Permission::firstOrCreate([
                Permission::CATEGORY => $handle,
                Permission::NAME => $key,
            ]);
        }
    }

    #endregion
}
