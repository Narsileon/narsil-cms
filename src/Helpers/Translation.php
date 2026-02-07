<?php

namespace Narsil\Cms\Helpers;

#region USE

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class Translation
{
    #region PUBLIC METHODS

    /**
     * @param string $attribute
     * @param array $replace
     * @param string|null $locale
     *
     * @return string
     */
    public static function get(string $attribute, array $replace = [], ?string $locale = null): string
    {
        $namespaces = static::getNamespaces();

        foreach ($namespaces as $namespace)
        {
            if (Lang::has("$namespace::$attribute", $locale))
            {
                return trans("$namespace::$attribute", $replace, $locale);
            }
        }

        return $attribute;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    protected static function getNamespaces(): array
    {
        return Cache::rememberForever('lang-namespaces', function ()
        {
            $namespaces = Lang::getLoader()->namespaces();

            return array_filter(array_keys($namespaces), function ($namespace)
            {
                return Str::contains($namespace, 'narsil');
            });
        });
    }

    #endregion
}
