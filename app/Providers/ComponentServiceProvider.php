<?php

namespace App\Providers;

#region USE

use App\Contracts\Components\Navigation\Sidebar as SidebarContract;
use App\Contracts\Components\Navigation\UserMenu as UserMenuContract;
use App\Http\Components\Navigation\AuthMenu;
use App\Http\Components\Navigation\GuestMenu;
use App\Http\Components\Navigation\Sidebar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ComponentServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->bindComponents();
    }

    /**
     * {@inheritdoc}
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
