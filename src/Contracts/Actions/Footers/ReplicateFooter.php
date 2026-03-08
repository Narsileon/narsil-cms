<?php

namespace Narsil\Cms\Contracts\Actions\Footers;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Globals\Footer;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface ReplicateFooter extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Footer $footer
     *
     * @return Footer
     */
    public function run(Footer $footer): Footer;

    #endregion
}
