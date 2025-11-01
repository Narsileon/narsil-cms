<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Arr;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class HostService
{
    #region PUBLIC METHODS

    /**
     * @param Host $host
     *
     * @return void
     */
    public static function replicateHost(Host $host): void
    {
        $replicated = $host->replicate();

        $replicated
            ->fill([
                Host::HANDLE => DatabaseService::generateUniqueValue($replicated, Host::HANDLE, $host->{Host::HANDLE}),
            ])
            ->save();
    }

    /**
     * @param HostLocale $hostLocale
     * @param array $languages
     *
     * @return void
     */
    public static function syncLanguages(HostLocale $hostLocale, array $languages): void
    {
        $processed = [];

        foreach ($languages as $position => $language)
        {
            $id = Arr::get($language, HostLocaleLanguage::UUID);

            $hostLocaleLanguage = $hostLocale
                ->languages()
                ->find($id);

            if ($hostLocaleLanguage)
            {
                $hostLocaleLanguage
                    ->update([
                        HostLocaleLanguage::LANGUAGE => Arr::get($language, HostLocaleLanguage::LANGUAGE),
                        HostLocaleLanguage::POSITION => $position,
                    ]);
            }
            else
            {
                $hostLocaleLanguage = $hostLocale
                    ->languages()
                    ->create([
                        HostLocaleLanguage::LANGUAGE => Arr::get($language, HostLocaleLanguage::LANGUAGE),
                        HostLocaleLanguage::POSITION => $position,
                    ]);
            }

            $processed[] = $hostLocaleLanguage->{HostLocaleLanguage::UUID};
        }

        $hostLocale
            ->languages()
            ->whereNotIn(HostLocaleLanguage::UUID, $processed)
            ->delete();
    }

    /**
     * @param Host $host
     * @param array $locales
     *
     * @return void
     */
    public static function syncLocales(Host $host, array $locales): void
    {
        $currentLocales = $host->locales()->get()->keyBy(HostLocale::UUID);

        $processed = [];

        foreach ($locales as $position => $locale)
        {
            $uuid = Arr::get($locale, HostLocale::UUID);

            $attributes = [
                HostLocale::COUNTRY  => Arr::get($locale, HostLocale::COUNTRY),
                HostLocale::PATTERN  => Arr::get($locale, HostLocale::PATTERN),
                HostLocale::POSITION => $position,
            ];

            $hostLocale = $currentLocales->get($uuid);

            if ($hostLocale)
            {
                $hostLocale->update($attributes);
            }
            else
            {
                $hostLocale = $host
                    ->locales()
                    ->create($attributes);
            }

            $processed[] = $hostLocale->{HostLocale::UUID};

            static::syncLanguages($hostLocale, Arr::get($locale, HostLocale::RELATION_LANGUAGES, []));
        }

        $host
            ->locales()
            ->whereNotIn(HostLocale::UUID, $processed)
            ->delete();
    }

    #endregion
}
