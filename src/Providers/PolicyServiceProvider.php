<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Narsil\Cms\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PolicyServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Gate::before(function (User $user)
        {
            if ($user->hasRole('super_admin'))
            {
                return true;
            };
        });

        $this->bootPolicies();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the configured policies.
     *
     * @return void
     */
    protected function bootPolicies(): void
    {
        $config = Config::get('narsil.models.policies', []);

        foreach ($config as $model => $policy)
        {
            Gate::policy($model, $policy);
        }
    }

    #endregion
}
