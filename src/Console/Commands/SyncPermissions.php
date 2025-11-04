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

            $baseHandle = $this->getFictiveTableName($model);

            $methods = $policyReflection->getMethods(\ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method)
            {
                $methodName = $method->getName();

                if (in_array($methodName, ['__construct', 'before']))
                {
                    continue;
                }

                $permission = PermissionService::getName($baseHandle, $methodName);

                Permission::firstOrCreate([
                    Permission::HANDLE => $permission,
                ], [
                    Permission::NAME => $permission,
                ]);

                $this->line("The permission '{$permission}' has been created.");
            }
        }

        $this->info('The permissions have been successfully synchronized.');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param string $model
     *
     * @return string
     */
    protected function getFictiveTableName(string $model): string
    {
        $modelName = class_basename($model);

        return Str::plural(Str::snake($modelName));
    }

    #endregion
}
