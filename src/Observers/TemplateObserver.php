<?php

namespace Narsil\Observers;

#region USE

use Narsil\Database\Migrations\CollectionMigration;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Structures\Template;
use Narsil\Models\Policies\Permission;
use Narsil\Services\GraphQLService;
use Narsil\Services\PermissionService;

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
        $permissions = [
            PermissionEnum::VIEW->value,
            PermissionEnum::CREATE->value,
            PermissionEnum::UPDATE->value,
            PermissionEnum::DELETE->value,
        ];

        foreach ($permissions as $permission)
        {
            $handle = PermissionService::getHandle($template->{Template::HANDLE}, $permission);

            $name = trans("narsil::permissions.$permission", [
                'model' => $template->{Template::SINGULAR},
                'table' => $template->{Template::PLURAL},
            ]);

            Permission::firstOrCreate([
                Permission::HANDLE => $handle,
            ], [
                Permission::NAME => $name,
            ]);
        }
    }

    #endregion
}
