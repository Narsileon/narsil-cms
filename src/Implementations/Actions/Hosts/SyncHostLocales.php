<?php

namespace Narsil\Cms\Implementations\Actions\Hosts;

#region USE

use Illuminate\Support\Arr;
use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Hosts\SyncHostLocaleLanguages;
use Narsil\Cms\Contracts\Actions\Hosts\SyncHostLocales as Contract;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SyncHostLocales extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Host $host, array $locales): Host
    {
        $currentLocales = $host->locales()->get()->keyBy(HostLocale::UUID);

        $processed = [];

        foreach ($locales as $position => $locale)
        {
            $uuid = Arr::get($locale, HostLocale::UUID);

            $attributes = [
                HostLocale::COUNTRY  => Arr::get($locale, HostLocale::COUNTRY, 'default'),
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

            app(SyncHostLocaleLanguages::class)
                ->run($hostLocale, Arr::get($locale, HostLocale::RELATION_LANGUAGES, []));
        }

        $host
            ->locales()
            ->whereNotIn(HostLocale::UUID, $processed)
            ->delete();

        return $host;
    }

    #endregion
}
