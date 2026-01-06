<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Services\DatabaseService;

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
    public static function replicate(Host $host): void
    {
        $replicated = $host->replicate();

        $replicated
            ->fill([
                Host::HOST => DatabaseService::generateUniqueValue($replicated, Host::HOST, $host->{Host::HOST}),
            ])
            ->save();

        static::syncLocales($replicated, $host->locales()->get()->toArray());
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

            HostLocaleService::syncLanguages($hostLocale, Arr::get($locale, HostLocale::RELATION_LANGUAGES, []));
        }

        $host
            ->locales()
            ->whereNotIn(HostLocale::UUID, $processed)
            ->delete();
    }

    /**
     * @param Host $host
     * @param array $locales
     *
     * @return void
     */
    public static function syncOtherLocales(Host $host, array $locales): void
    {
        $currentLocales = $host->other_locales()->get()->keyBy(HostLocale::UUID);

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
                    ->other_locales()
                    ->create($attributes);
            }

            $processed[] = $hostLocale->{HostLocale::UUID};

            HostLocaleService::syncLanguages($hostLocale, Arr::get($locale, HostLocale::RELATION_LANGUAGES, []));
        }

        $host
            ->other_locales()
            ->whereNotIn(HostLocale::UUID, $processed)
            ->delete();
    }

    #endregion
}
