<?php

namespace Narsil\Cms\Implementations\Actions\Hosts;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Base\Services\DatabaseService;
use Narsil\Cms\Contracts\Actions\Hosts\ReplicateHost as Contract;
use Narsil\Cms\Contracts\Actions\Hosts\SyncHostLocales;
use Narsil\Cms\Models\Hosts\Host;

#endregion

/**
 * @author Jonathan Rigaux
 */
class ReplicateHost extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Host $host): Host
    {
        $replicated = $host->replicate();

        $replicated
            ->fill([
                Host::HOSTNAME => DatabaseService::generateUniqueValue($replicated, Host::HOSTNAME, $host->{Host::HOSTNAME}),
            ])
            ->save();

        $locales = $host->locales()->get()->toArray();

        app(SyncHostLocales::class)
            ->run($replicated, $locales);

        return $replicated;
    }

    #endregion
}
