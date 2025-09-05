<?php

namespace Narsil\Observers;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Elements\Template;
use Narsil\Models\Policies\Permission;
use Narsil\Services\MigrationService;

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
        $this->createPermissions($template->{Template::HANDLE});
    }

    /**
     * @param Template $template
     *
     * @return void
     */
    public function saved(Template $template): void
    {
        MigrationService::syncTable($template);
    }

    #endregion

    #region PROTECTED METHODS

    protected function createPermissions(string $handle): void
    {
        $permissions = [
            PermissionEnum::VIEW,
            PermissionEnum::CREATE,
            PermissionEnum::UPDATE,
            PermissionEnum::DELETE,
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
