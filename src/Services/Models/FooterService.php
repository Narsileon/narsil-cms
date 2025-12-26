<?php

namespace Narsil\Services\Models;

#region USE

use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterLink;
use Narsil\Models\Globals\FooterSocialMedium;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FooterService
{
    #region PUBLIC METHODS

    /**
     * @param Footer $footer
     * @param array $links
     *
     * @return void
     */
    public static function syncLinks(Footer $footer, array $links): void
    {
        $uuids = [];

        foreach ($links as $key => $link)
        {
            $fieldOption = FooterLink::updateOrCreate([
                FooterLink::FOOTER_ID => $footer->{Footer::ID},
                FooterLink::POSITION => $key,
            ], $link);

            $uuids[] = $fieldOption->{FooterLink::UUID};
        }

        $footer
            ->links()
            ->whereNotIn(FooterLink::UUID, $uuids)
            ->delete();
    }

    /**
     * @param Footer $footer
     * @param array $links
     *
     * @return void
     */
    public static function syncSocialMedia(Footer $footer, array $socialMedia): void
    {
        $uuids = [];

        foreach ($socialMedia as $key => $socialMedium)
        {
            $fieldOption = FooterSocialMedium::updateOrCreate([
                FooterSocialMedium::FOOTER_ID => $footer->{Footer::ID},
                FooterSocialMedium::POSITION => $key,
            ], $socialMedium);

            $uuids[] = $fieldOption->{FooterLink::UUID};
        }

        $footer
            ->social_media()
            ->whereNotIn(FooterSocialMedium::UUID, $uuids)
            ->delete();
    }

    #endregion
}
