<?php

namespace Narsil\Observers;

#region USE

use Illuminate\Support\Facades\Artisan;
use Narsil\Database\Migrations\TemplateMigration;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Collections\Template;
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
        Artisan::call('make:entity', [
            'name' => class_basename($model->entityClass()),
            'template' => $model->{Template::ID},
        ]);

        Artisan::call('make:entity-node', [
            'name' => class_basename($model->entityNodeClass()),
            'template' => $model->{Template::ID},
        ]);

        Artisan::call('make:entity-node-relation', [
            'name' => class_basename($model->entityNodeRelationClass()),
            'template' => $model->{Template::ID},
        ]);

        new TemplateMigration($model)->up();

        $this->createPermissions($model);
    }

    /**
     * @param Template $model
     *
     * @return void
     */
    public function deleted(Template $model): void
    {
        new TemplateMigration($model)->down();
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
            $handle = PermissionService::getHandle($model->{Template::TABLE_NAME}, $permission);

            $name = trans("narsil::permissions.$permission", [
                'model' => $model->{Template::SINGULAR},
                'table' => $model->{Template::PLURAL},
            ]);

            Permission::firstOrCreate([
                Permission::NAME => $handle,
            ], [
                Permission::LABEL => $name,
            ]);
        }
    }

    #endregion
}
