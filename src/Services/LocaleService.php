<?php

namespace Narsil\Cms\Services;

#region USE

use Illuminate\Support\Facades\App;
use Locale;
use Narsil\Base\Http\Data\OptionData;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class LocaleService
{
    #region PUBLIC METHODS

    /**
     * Get the country options.
     *
     * @return array<OptionData>
     */
    public static function countryOptions(): array
    {
        return collect(ResourceBundle::getLocales(''))
            ->map(function ($locale)
            {
                return Locale::getRegion($locale);
            })
            ->filter(function ($region)
            {
                return preg_match('/^[A-Z]{2}$/', $region);
            })
            ->unique()
            ->map(function ($code)
            {
                $label = Locale::getDisplayRegion('_' . $code, App::getLocale());

                if (!$label || $label === $code)
                {
                    return null;
                }

                return new OptionData(
                    label: ucfirst($label),
                    value: $code
                );
            })
            ->filter()
            ->sortBy(function (OptionData $option)
            {
                return $option->label;
            }, SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->all();
    }

    /**
     * Get the language options.
     *
     * @return array<SelectOption>
     */
    public static function languageOptions(): array
    {
        return collect(ResourceBundle::getLocales(''))
            ->map(function ($locale)
            {
                return Locale::getPrimaryLanguage($locale);
            })
            ->filter(function ($code)
            {
                return preg_match('/^[a-z]{2}$/i', $code);
            })
            ->unique()
            ->map(function ($code)
            {
                $label = Locale::getDisplayLanguage($code, App::getLocale());

                if (!$label || $label === $code)
                {
                    return null;
                }

                return new OptionData(
                    label: ucfirst($label),
                    value: $code
                );
            })
            ->filter()
            ->sortBy(function (OptionData $option)
            {
                return $option->label;
            }, SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->all();
    }


    #endregion
}
