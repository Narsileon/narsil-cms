<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfigServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootPublishes();
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->mergeConfiguration();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the publishes.
     *
     * @return void
     */
    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../../config' => config_path(),
        ], 'narsil-cms-configuration');
    }

    /**
     * Merge the configuration.
     *
     * @return void
     */
    protected function mergeConfiguration(): void
    {
        $configs = [
            'narsil.fields' => __DIR__ . '/../../config/narsil/fields.php',
            'narsil.form-requests' => __DIR__ . '/../../config/narsil/form-requests.php',
            'narsil.forms'  => __DIR__ . '/../../config/narsil/forms.php',
            'narsil.locales' => __DIR__ . '/../../config/narsil/locales.php',
            'narsil.menus' => __DIR__ . '/../../config/narsil/menus.php',
            'narsil.observers' => __DIR__ . '/../../config/narsil/observers.php',
            'narsil.policies' => __DIR__ . '/../../config/narsil/policies.php',
            'narsil.resources' => __DIR__ . '/../../config/narsil/resources.php',
            'narsil.tables' => __DIR__ . '/../../config/narsil/tables.php',
        ];

        foreach ($configs as $key => $path)
        {
            $this->mergeConfigFrom($path, $key);
        }
    }

    #endregion
}
