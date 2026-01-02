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
     * @param Site $model
     *
     * @return void
     */
    public function creating(Site $model): void
    {
        if (Site::count() === 0)
        {
            $this->createFooter($model);
        }
    }

    /**
     * @param Site $model
     *
     * @return void
     */
    public function created(Site $model): void
    {
        $homePage = $this->createHomePage($model);

        if (Site::count() === 1)
        {
            $this->createPages($model, $homePage);
        }
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Site $model
     *
     * @return void
     */
    protected function createFooter(Site $model): void
    {
        $footer = Footer::factory()->create([
            Footer::HANDLE => $model->{Site::HANDLE},
        ]);

        $model->fill([
            Site::FOOTER_ID => $footer->{Footer::ID},
        ]);
    }

    /**
     * @param Site $model
     *
     * @return SitePage
     */
    protected function createHomePage(Site $model): SitePage
    {
        return SitePage::create([
            SitePage::SITE_ID => $model->{Host::ID},
            SitePage::SLUG => 'home',
            SitePage::TITLE => 'Home',
        ]);
    }

    /**
     * @param Site $model
     * @param SitePage $homePage
     *
     * @return void
     */
    protected function createPages(Site $model, SitePage $homePage): void
    {
        $contactPage = SitePage::create([
            SitePage::SHOW_IN_MENU => true,
            SitePage::SITE_ID => $model->{Site::ID},
            SitePage::SLUG => 'contact',
            SitePage::TITLE => 'Contact',
        ]);

        $imprintPage = SitePage::create([
            SitePage::SHOW_IN_MENU => false,
            SitePage::SITE_ID => $model->{Site::ID},
            SitePage::SLUG => 'imprint',
            SitePage::TITLE => 'Imprint',
        ]);

        $privacyNoticePage = SitePage::create([
            SitePage::SHOW_IN_MENU => false,
            SitePage::SITE_ID => $model->{Site::ID},
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
            FooterLink::FOOTER_ID => $model->{Footer::ID},
            FooterLink::SITE_PAGE_ID => $imprintPage->{SitePage::ID},
        ]);

        FooterLink::create([
            FooterLink::FOOTER_ID => $model->{Footer::ID},
            FooterLink::SITE_PAGE_ID => $privacyNoticePage->{SitePage::ID},
        ]);
    }

    #endregion
}
