<?php

declare(strict_types=1);

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Narsil\Cms\Database\Seeders\ValidationRuleSeeder;
use Narsil\Cms\Models\ValidationRule;

#endregion

final class MigrationServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootEvent();
        $this->bootMigrations();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the events.
     *
     * @return void
     */
    protected function bootEvent(): void
    {
        if (app()->runningInConsole() && request()->server('argv')[1] === 'migrate:fresh')
        {
            DB::statement('DROP SCHEMA IF EXISTS cms CASCADE');
        }

        Event::listen(MigrationsEnded::class, function ()
        {
            if (Schema::hasTable(ValidationRule::TABLE))
            {
                new ValidationRuleSeeder()->run();
            }
        });
    }

    /**
     * Boot the migrations.
     *
     * @return void
     */
    protected function bootMigrations(): void
    {
        $this->loadMigrationsFrom([
            __DIR__ . '/../../database/migrations',
        ]);
    }

    #endregion
}
