<?php

namespace Narsil\Cms\Contracts\Actions\Sites;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface SyncSitePageEntities extends Action
{
    #region PUBLIC METHODS

    /**
     * @param SitePage $sitePage
     * @param array $entities
     *
     * @return SitePage
     */
    public function run(SitePage $sitePage, array $entities): SitePage;

    #endregion
}
