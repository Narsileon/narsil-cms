<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
        $config = config('narsil.policies', []);

        foreach ($config as $model => $policy)
        {
            Gate::policy($model, $policy);
        }
    }

    #endregion
}
