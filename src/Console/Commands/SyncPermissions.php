<?php

namespace Narsil\Console\Commands;

#region USE

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Narsil\Models\Policies\Permission;
use Narsil\Services\PermissionService;
use ReflectionClass;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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

            $methods = $policyReflection->getMethods(\ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method)
            {
                $methodName = $method->getName();

                if (in_array($methodName, ['__construct', 'before']))
                {
                    continue;
                }

                $permission = PermissionService::getName($model::TABLE, $methodName);

                Permission::updateOrCreate([
                    Permission::NAME => $permission,
                ], [
                    Permission::CATEGORY => $model::TABLE,
                ]);

                $this->line("The permission '{$permission}' has been created.");
            }
        }

        $this->info('The permissions have been successfully synchronized.');
    }

    #endregion
}
