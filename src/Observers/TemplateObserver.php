<?php

namespace Narsil\Observers;

#region USE

use Illuminate\Support\Facades\Schema;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Structures\Template;
use Narsil\Models\Policies\Permission;
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
     * @param Template $model
     *
     * @return void
     */
    public function created(Template $model): void
    {
        $this->createPermissions($model);
    }

    /**
     * @param Template $model
     *
     * @return void
     */
    public function deleted(Template $model): void
    {
        Schema::dropIfExists($model->{Template::HANDLE});
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Template $template
     *
     * @return void
     */
    protected function createPermissions(Template $model): void
    {
        $permissions = [
            PermissionEnum::VIEW->value,
            PermissionEnum::CREATE->value,
            PermissionEnum::UPDATE->value,
            PermissionEnum::DELETE->value,
        ];

        foreach ($permissions as $permission)
        {
            $handle = PermissionService::getHandle($model->{Template::HANDLE}, $permission);

            $name = trans("narsil::permissions.$permission", [
                'model' => $model->{Template::SINGULAR},
                'table' => $model->{Template::PLURAL},
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
