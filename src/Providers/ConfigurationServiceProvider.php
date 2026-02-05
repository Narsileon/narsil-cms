<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfigurationServiceProvider extends ServiceProvider
{
    #region CONSTANTS

    /**
     * The configuration path.
     *
     * @var string
     */
    protected const CONFIGURATION_PATH = __DIR__ . '/../../config';

    #endregion

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
            self::CONFIGURATION_PATH => config_path(),
        ], 'narsil-cms-configuration');
    }

    /**
     * Merge the configuration.
     *
     * @return void
     */
    protected function mergeConfiguration(): void
    {
        $files = $this->getConfigurationFiles('/narsil');

        foreach ($files as $file)
        {
            if (!$file->isFile() || $file->getExtension() !== 'php')
            {
                continue;
            }

            $path = $file->getPathname();
            $key = $this->getConfigurationKey($path);

            $this->mergeConfigFrom($path, $key);
        }
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function getConfigurationKey(string $path): string
    {
        return Str::of($path)
            ->after(self::CONFIGURATION_PATH . DIRECTORY_SEPARATOR)
            ->replace(DIRECTORY_SEPARATOR, '.')
            ->beforeLast('.php');
    }

    /**
     * @param string $path
     *
     * @return iterable
     */
    protected function getConfigurationFiles(string $path): iterable
    {
        $directories = new RecursiveDirectoryIterator(self::CONFIGURATION_PATH . $path, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($directories);

        return $files;
    }

    #endregion
}
