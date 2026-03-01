<?php

namespace Narsil\Cms\Services;

#region USE

use Narsil\Base\Services\DatabaseService;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;
use Narsil\Cms\Models\Globals\FooterSocialMedium;

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
     *
     * @return void
     */
    public static function replicate(Footer $footer): void
    {
        $replicated = $footer->replicate();

        $replicated
            ->fill([
                Footer::SLUG => DatabaseService::generateUniqueValue($replicated, Footer::SLUG, $footer->{Footer::SLUG}),
            ])
            ->save();

        static::syncLinks($replicated, $footer->links()->get()->toArray());
        static::syncSocialMedia($replicated, $footer->social_media()->get()->toArray());
    }

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
    }

    #endregion
}
