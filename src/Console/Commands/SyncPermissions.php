<?php

declare(strict_types=1);

namespace Narsil\Cms\Console\Commands;

#region USE

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Models\Policies\Permission;
use Narsil\Base\Narsil;
use Narsil\Base\Services\PermissionService;
use ReflectionClass;

#endregion

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
        $narsil = app(Narsil::class);
        $models = array_unique(array_merge(
            array_keys($narsil->morphs()),
            array_keys($narsil->modelDefinitions()),
        ));

        foreach ($models as $model)
        {
            if (!class_exists($model))
            {
                continue;
            }

            $attributes = (new ReflectionClass($model))->getAttributes(UsePolicy::class);

            if ($attributes === [])
            {
                continue;
            }

            $policy = $attributes[0]->newInstance()->class;
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

                foreach ($narsil->getLocales() as $locale)
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
