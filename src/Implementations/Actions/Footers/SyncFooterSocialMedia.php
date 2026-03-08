<?php

namespace Narsil\Cms\Implementations\Actions\Footers;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Footers\SyncFooterSocialMedia as Contract;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;
use Narsil\Cms\Models\Globals\FooterSocialMedium;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SyncFooterSocialMedia extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Footer $footer, array $socialMedia): Footer
    {
        $uuids = [];

        foreach ($socialMedia as $key => $socialMedium)
        {
            $fieldOption = FooterSocialMedium::updateOrCreate([
                FooterSocialMedium::FOOTER_ID => $footer->{Footer::ID},
                FooterSocialMedium::POSITION => $key,
            ], [
                ...$socialMedium,
                FooterSocialMedium::POSITION => $key,
            ]);

            $uuids[] = $fieldOption->{FooterLink::UUID};
        }

        $footer
            ->social_media()
            ->whereNotIn(FooterSocialMedium::UUID, $uuids)
            ->delete();

        return $footer;
    }

    #endregion
}
