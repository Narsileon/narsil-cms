<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class HostLocaleService
{
    #region PUBLIC METHODS

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

    #endregion
}
