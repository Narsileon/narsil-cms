<?php

namespace Narsil\Cms\Implementations\Actions\Footers;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Base\Services\DatabaseService;
use Narsil\Cms\Contracts\Actions\Footers\ReplicateFooter as Contract;
use Narsil\Cms\Models\Globals\Footer;

#endregion

/**
 * @author Jonathan Rigaux
 */
class ReplicateFooter extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Footer $footer): Footer
    {
        $replicated = $footer->replicate();

        $replicated
            ->fill([
                Footer::SLUG => DatabaseService::generateUniqueValue($replicated, Footer::SLUG, $footer->{Footer::SLUG}),
            ])
            ->save();

        return $replicated;
    }

    #endregion
}
