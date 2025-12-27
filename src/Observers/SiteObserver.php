<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterLink;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteObserver
{
    #region PUBLIC METHODS

    /**
     * @param Site $site
     *
     * @return void
     */
    public function creating(Site $site): void
    {
        if (Site::count() === 0)
        {
            $this->createFooter($site);
        }
    }

    /**
     * @param Site $site
     *
     * @return void
     */
    public function created(Site $site): void
    {
        $homePage = $this->createHomePage($site);

        if (Site::count() === 1)
        {
            $this->createPages($site, $homePage);
        }
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Site $site
     *
     * @return void
     */
    protected function createFooter(Site $site): void
    {
        $footer = Footer::factory()->create([
            Footer::HANDLE => $site->{Site::HANDLE},
        ]);

        $site->fill([
            Site::FOOTER_ID => $footer->{Footer::ID},
        ]);
    }

    /**
     * @param Site $site
     *
     * @return SitePage
     */
    protected function createHomePage(Site $site): SitePage
    {
        return SitePage::create([
            SitePage::SITE_ID => $site->{Host::ID},
            SitePage::SLUG => 'home',
            SitePage::TITLE => 'Home',
        ]);
    }

    /**
     * @param Site $site
     * @param SitePage $homePage
     *
     * @return void
     */
    protected function createPages(Site $site, SitePage $homePage): void
    {
        $contactPage = SitePage::create([
            SitePage::SHOW_IN_MENU => true,
            SitePage::SITE_ID => $site->{Site::ID},
            SitePage::SLUG => 'contact',
            SitePage::TITLE => 'Contact',
        ]);

        $imprintPage = SitePage::create([
            SitePage::SHOW_IN_MENU => false,
            SitePage::SITE_ID => $site->{Site::ID},
            SitePage::SLUG => 'imprint',
            SitePage::TITLE => 'Imprint',
        ]);

        $privacyNoticePage = SitePage::create([
            SitePage::SHOW_IN_MENU => false,
            SitePage::SITE_ID => $site->{Site::ID},
            SitePage::SLUG => 'pricacy-notice',
            SitePage::TITLE => 'Privacy Notice',
        ]);

        $contactPage->update([
            SitePage::PARENT_ID => $homePage->{SitePage::ID},
            SitePage::RIGHT_ID => $imprintPage->{SitePage::ID},
        ]);

        $imprintPage->update([
            SitePage::LEFT_ID => $contactPage->{SitePage::ID},
            SitePage::PARENT_ID => $homePage->{SitePage::ID},
            SitePage::RIGHT_ID => $privacyNoticePage->{SitePage::ID},
        ]);

        $privacyNoticePage->update([
            SitePage::PARENT_ID => $homePage->{SitePage::ID},
            SitePage::LEFT_ID => $imprintPage->{SitePage::ID},
        ]);

        FooterLink::create([
            FooterLink::FOOTER_ID => $site->{Footer::ID},
            FooterLink::SITE_PAGE_ID => $imprintPage->{SitePage::ID},
        ]);

        FooterLink::create([
            FooterLink::FOOTER_ID => $site->{Footer::ID},
            FooterLink::SITE_PAGE_ID => $privacyNoticePage->{SitePage::ID},
        ]);
    }

    #endregion
}
