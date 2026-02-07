<?php

namespace Narsil\Cms\Console\Commands;

#region USE

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Services\PermissionService;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SyncPermissions extends Command
{
    #region PROPERTIES

    /**
     * {@inheritDoc}
     */
    protected $description = 'Generate permissions based on policy methods.';

    /**
     * {@inheritDoc}
     */
    protected $signature = 'narsil:sync-permissions';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function handle(): void
    {
        $config = Config::get('narsil.models.policies', []);

        foreach ($config as $model => $policy)
        {
            if (!class_exists($policy))
            {
                continue;
            }

            $policyReflection = new ReflectionClass($policy);

            $table = $model::TABLE;

            $methods = $policyReflection->getMethods(\ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method)
            {
                $permission = $method->getName();

                if (in_array($permission, ['__construct', 'before']))
                {
                    continue;
                }

                $handle = PermissionService::getHandle($table, $permission);

                $names = [];

                foreach (Config::get('narsil.locales', ['en']) as $locale)
                {
                    $names[$locale] = PermissionService::getName($model, $permission, $locale);
                }

                Permission::firstOrCreate([
                    Permission::NAME => $handle,
                ], [
                    Permission::LABEL => $names,
                ]);

                $this->line("The permission '{$handle}' has been created.");
            }
        }

        $this->info('The permissions have been successfully synchronized.');
    }

    #endregion
}
