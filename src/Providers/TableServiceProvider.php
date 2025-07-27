<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Contracts\Tables\Resources\FieldTable as FieldTableContract;
use Narsil\Contracts\Tables\Resources\SiteTable as SiteTableContract;
use Narsil\Contracts\Tables\Resources\SiteGroupTable as SiteGroupTableContract;
use Narsil\Contracts\Tables\Resources\UserTable as UserTableContract;
use Narsil\Tables\Resources\FieldTable;
use Narsil\Tables\Resources\SiteTable;
use Narsil\Tables\Resources\SiteGroupTable;
use Narsil\Tables\Resources\UserTable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TableServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $map = $this->map();

        foreach ($map as $abstract => $concrete)
        {
            $this->app->singleton($abstract, $concrete);
            $this->app->tag($abstract, ['tables']);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        //
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,string>
     */
    protected function map(): array
    {
        return [
            FieldTableContract::class => FieldTable::class,
            SiteTableContract::class => SiteTable::class,
            SiteGroupTableContract::class => SiteGroupTable::class,
            UserTableContract::class => UserTable::class,
        ];
    }

    #endregion
}
