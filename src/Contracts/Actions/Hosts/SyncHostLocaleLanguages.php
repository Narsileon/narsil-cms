<?php

namespace Narsil\Cms\Contracts\Actions\Hosts;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Hosts\HostLocale;

#endregion

interface SyncHostLocaleLanguages extends Action
{
    #region PUBLIC METHODS

    /**
     * @param HostLocale $hostLocale
     * @param array $languages
     *
     * @return HostLocale
     */
    public function run(HostLocale $hostLocale, array $languages): HostLocale;

    #endregion
}
