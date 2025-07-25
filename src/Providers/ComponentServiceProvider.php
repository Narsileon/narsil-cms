<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Narsil\Contracts\Components\Navigation\Sidebar as SidebarContract;
use Narsil\Contracts\Components\Navigation\UserMenu as UserMenuContract;
use Narsil\Http\Components\Navigation\AuthMenu;
use Narsil\Http\Components\Navigation\GuestMenu;
use Narsil\Http\Components\Navigation\Sidebar;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ComponentServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->bindComponents();
    }

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        //
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function bindComponents(): void
    {
        $this->app->singleton(SidebarContract::class, Sidebar::class);

        $this->app->bind(UserMenuContract::class, function ($app)
        {
            return Auth::check() ? new AuthMenu() : new GuestMenu();
        });
    }

    #endregion
}
