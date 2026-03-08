<?php

namespace Narsil\Cms\Implementations\Actions\Hosts;

#region USE

use Illuminate\Support\Arr;
use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Hosts\SyncHostLocaleLanguages as Contract;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SyncHostLocaleLanguages extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(HostLocale $hostLocale, array $languages): HostLocale
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

        return $hostLocale;
    }

    #endregion
}
