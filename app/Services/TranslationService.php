<?php

namespace App\Services;

#region USE

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class TranslationService
{
    #region PUBLIC METHODS

    /**
     * @param string $locale
     *
     * @return array
     */
    public static function getTranslations(string $locale): array
    {
        return Cache::rememberForever("translations_$locale", function () use ($locale)
        {
            $jsonTranslations = Lang::get('*', [], $locale);

            if (!is_array($jsonTranslations))
            {
                $jsonTranslations = [];
            }

            $phpTranslations = [];

            $files = Config::get("narsil.translations", []);

            foreach ($files as $file)
            {
                $phpTranslations += static::flattenTranslations(Lang::get($file, [], $locale), $file);
            }

            return array_merge($phpTranslations, $jsonTranslations);
        });
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param array|string $translations
     * @param string $prefix
     *
     * @return array
     */
    private static function flattenTranslations(array|string $translations, string $prefix): array
    {
        if (!is_array($translations))
        {
            return [];
        }

        $result = [];

        foreach ($translations as $key => $value)
        {
            $fullKey = "$prefix.$key";

            if (is_array($value))
            {
                $result += self::flattenTranslations($value, $fullKey);
            }
            else
            {
                $result[$fullKey] = $value;
            }
        }

        return $result;
    }

    #endregion
}
