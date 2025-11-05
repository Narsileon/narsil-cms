<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Hosts\Host;
use Narsil\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostObserver
{
    #region PUBLIC METHODS

    /**
     * @param Host $host
     *
     * @return void
     */
    public function created(Host $host): void
    {
        $this->createRootPage($host);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Host $host
     *
     * @return void
     */
    protected function createRootPage(Host $host): void
    {
        SitePage::create([
            SitePage::SITE_ID => $host->{Host::ID},
            SitePage::SLUG => 'root',
            SitePage::TITLE => 'Root',
        ]);
    }

    #endregion
}
