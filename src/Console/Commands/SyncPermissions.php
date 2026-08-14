<?php

declare(strict_types=1);

namespace Narsil\Cms\Console\Commands;

#region USE

use Illuminate\Console\Command;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Models\Policies\Permission;
use Narsil\Base\Narsil;
use Narsil\Base\Services\PermissionService;
use ReflectionClass;

#endregion

/**
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
        $config = app(Narsil::class)->policies();

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
                $value = $method->getName();

                $ability = AbilityEnum::tryFrom($value);

                if (!$ability)
                {
                    continue;
                }

                $handle = PermissionService::getName($table, $ability);

                $names = [];

                foreach (app(Narsil::class)->getLocales() as $locale)
                {
                    $names[$locale] = PermissionService::getLabel($table, $ability->value, $locale);
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
