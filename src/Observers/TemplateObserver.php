<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Elements\Template;
use Narsil\Models\Policies\Permission;

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
        $this->createPermissions($template->{Template::HANDLE});
    }

    #endregion

    #region PRIVATE METHODS

    private function createPermissions(string $handle): void
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
                Permission::HANDLE => $key,
            ], [
                Permission::NAME => $key,
            ]);
        }
    }

    #endregion
}
