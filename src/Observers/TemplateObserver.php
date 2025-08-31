<?php

namespace Narsil\Observers;

#region USE

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

    public function saved(Template $template): void
    {
        MigrationService::syncTable($template);
    }

    #endregion

    #region PROTECTED METHODS

    protected function createPermissions(string $handle): void
    {
        $permissions = [
            'view',
            'create',
            'update',
            'delete',
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
