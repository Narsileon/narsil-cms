<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class NarsilServiceProvider extends ServiceProvider
{
    #region PROTECTED METHODS

    /**
     * Boot the API routes.
     *
     * @param string $path
     *
     * @return void
     */
    protected function bootApiRoutes(string $path): void
    {
        Route::middleware([
            'api',
            'auth:sanctum',
        ])
            ->prefix('api')
            ->as('api.')
            ->group($path);
    }

    /**
     * Boot the CMS routes.
     *
     * @param string $path
     *
     * @return void
     */
    protected function bootCmsRoutes(string $path): void
    {
        Route::middleware([
            'web',
            'narsil-cms',
        ])
            ->prefix('admin')
            ->group($path);
    }

    /**
     * Boot the web routes.
     *
     * @param string $path
     *
     * @return void
     */
    protected function bootWebRoutes(string $path): void
    {
        Route::middleware([
            'web',
        ])
            ->group($path);
    }

    /**
     * Merge the configuration.
     *
     * @param string $configPath
     *
     * @return void
     */
    protected function mergeConfiguration(string $configPath): void
    {
        $files = $this->getConfigurationFiles($configPath);

        foreach ($files as $file)
        {
            if (!$file->isFile() || $file->getExtension() !== 'php')
            {
                continue;
            }

            $pathname = $file->getPathname();
            $key = $this->getConfigurationKey($pathname);

            $this->mergeConfigFrom($pathname, $key);
        }
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param string $pathname
     *
     * @return string
     */
    private function getConfigurationKey(string $pathname): string
    {
        return Str::of($pathname)
            ->after('config' . DIRECTORY_SEPARATOR)
            ->replace(DIRECTORY_SEPARATOR, '.')
            ->beforeLast('.php');
    }

    /**
     * @param string $configPath
     *
     * @return iterable
     */
    private function getConfigurationFiles(string $configPath): iterable
    {
        $directories = new RecursiveDirectoryIterator("$configPath/narsil", RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($directories);

        return $files;
    }

    #endregion
}
