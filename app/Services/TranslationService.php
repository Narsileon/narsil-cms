<?php

namespace App\Services;

#region USE

use App\Models\User;
use App\Models\UserConfiguration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class TranslationService
{
    #region PUBLIC METHODS

    /**
     * @return string
     */
    public static function getLocale(): string
    {
        $locale = Session::get('locale');

        if (!$locale)
        {
            $locale = Auth::user()?->{User::RELATION_CONFIGURATION}?->{UserConfiguration::LOCALE};
        }

        if (!$locale)
        {
            $locale = App::getLocale();
        }

        return $locale;
    }

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

    #region PROTECTED METHODS

    /**
     * @param array|string $translations
     * @param string $prefix
     *
     * @return array
     */
    protected static function flattenTranslations(array|string $translations, string $prefix): array
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
