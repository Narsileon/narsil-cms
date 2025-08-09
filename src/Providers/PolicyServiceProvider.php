<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PolicyServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability)
        {
            return $user->hasPermission($ability);
        });

        $this->bootPolicies();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the policies from the config file.
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
