<?php

declare(strict_types=1);

namespace Narsil\Cms\Contracts\Actions\Footers;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Globals\Footer;

#endregion

interface SyncFooterSocialMedia extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Footer $footer
     * @param array $footerLinks
     *
     * @return Footer
     */
    public function run(Footer $footer, array $socialMedia): Footer;

    #endregion
}
