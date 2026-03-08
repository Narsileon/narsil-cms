<?php

namespace Narsil\Cms\Implementations\Actions\Footers;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Footers\SyncFooterLinks as Contract;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SyncFooterLinks extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Footer $footer, array $links): Footer
    {
        $uuids = [];

        foreach ($links as $key => $link)
        {
            $fieldOption = FooterLink::updateOrCreate([
                FooterLink::FOOTER_ID => $footer->{Footer::ID},
                FooterLink::POSITION => $key,
            ], [
                ...$link,
                FooterLink::POSITION => $key,
            ]);

            $uuids[] = $fieldOption->{FooterLink::UUID};
        }

        $footer
            ->links()
            ->whereNotIn(FooterLink::UUID, $uuids)
            ->delete();

        return $footer;
    }

    #endregion
}
