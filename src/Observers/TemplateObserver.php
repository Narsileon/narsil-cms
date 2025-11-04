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
 * @version 1.0.0
 * @author Jonathan Rigaux
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
        new CollectionMigration($template)->up();

        GraphQLService::generateTemplatesSchema();

        $this->createPermissions($template);
    }

    /**
     * @param Template $template
     *
     * @return void
     */
    public function deleted(Template $template): void
    {
        new CollectionMigration($template)->down();

        GraphQLService::generateTemplatesSchema();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Template $template
     *
     * @return void
     */
    protected function createPermissions(Template $template): void
    {
        $handle = $template->{Template::HANDLE};

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
                Permission::HANDLE => $key,
            ], [
                Permission::NAME => $key,
            ]);
        }
    }

    #endregion
}
