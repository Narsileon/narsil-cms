<?php

namespace Narsil\Console\Commands;

#region USE

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Narsil\Models\Policies\Permission;
use Narsil\Services\PermissionService;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SyncPermissions extends Command
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->signature = 'narsil:sync-permissions';
        $this->description = 'Generate permissions based on policy methods.';

        parent::__construct();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function handle(): void
    {
        $config = Config::get('narsil.policies');

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
                    Permission::HANDLE => $handle,
                ], [
                    Permission::NAME => $names,
                ]);

                $this->line("The permission '{$handle}' has been created.");
            }
        }

        $this->info('The permissions have been successfully synchronized.');
    }

    #endregion
}
