<?php

namespace Narsil\Observers;

#region USE

use Narsil\Database\Seeders\Entities\ContactEntitySeeder;
use Narsil\Database\Seeders\Entities\HomeEntitySeeder;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterLink;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Sites\SitePageEntity;

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
            $entity = new HomeEntitySeeder()->run();

            SitePageEntity::create([
                SitePageEntity::SITE_PAGE_ID => $homePage->{SitePage::ID},
                SitePageEntity::TARGET_ID => $entity->{Entity::ID},
                SitePageEntity::TARGET_TYPE => $entity->getTable(),
            ]);

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
            Footer::SLUG => 'main',
        ]);

        $model->fill([
            Site::FOOTER_ID => $footer->{Footer::ID},
        ]);
    }

    /**
     * @param Site $model
     *
     * @return void
     */
    protected function createHeader(Site $model): void
    {
        $header = Header::factory()->create([
            Header::SLUG => 'main',
        ]);

        $model->fill([
            Site::HEADER_ID => $header->{Header::ID},
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
        $contactPage = $this->createContactPage($model);
        $imprintPage = $this->createImprintPage($model);
        $privacyNoticePage = $this->createPrivacyNoticePage($model);

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
    }

    /**
     * @param Site $model
     *
     * @return SitePage
     */
    protected function createContactPage(Site $model): SitePage
    {
        $sitePage = SitePage::create([
            SitePage::SHOW_IN_MENU => true,
            SitePage::SITE_ID => $model->{Site::ID},
            SitePage::SLUG => 'contact',
            SitePage::TITLE => 'Contact',
        ]);

        $entity = new ContactEntitySeeder()->run();

        SitePageEntity::create([
            SitePageEntity::SITE_PAGE_ID => $sitePage->{SitePage::ID},
            SitePageEntity::TARGET_ID => $entity->{Entity::ID},
            SitePageEntity::TARGET_TYPE => $entity->getTable(),
        ]);

        return $sitePage;
    }

    /**
     * @param Site $model
     *
     * @return SitePage
     */
    protected function createHomePage(Site $model): SitePage
    {
        $sitePage = SitePage::create([
            SitePage::SITE_ID => $model->{Host::ID},
            SitePage::SLUG => 'home',
            SitePage::TITLE => 'Home',
        ]);

        return $sitePage;
    }

    /**
     * @param Site $model
     *
     * @return SitePage
     */
    protected function createImprintPage(Site $model): SitePage
    {
        $sitePage = SitePage::create([
            SitePage::SHOW_IN_MENU => false,
            SitePage::SITE_ID => $model->{Site::ID},
            SitePage::SLUG => 'imprint',
            SitePage::TITLE => 'Imprint',
        ]);

        FooterLink::create([
            FooterLink::FOOTER_ID => $model->{Footer::ID},
            FooterLink::SITE_PAGE_ID => $sitePage->{SitePage::ID},
        ]);

        return $sitePage;
    }

    /**
     * @param Site $model
     *
     * @return SitePage
     */
    protected function createPrivacyNoticePage(Site $model): SitePage
    {
        $sitePage = SitePage::create([
            SitePage::SHOW_IN_MENU => false,
            SitePage::SITE_ID => $model->{Site::ID},
            SitePage::SLUG => 'pricacy-notice',
            SitePage::TITLE => 'Privacy Notice',
        ]);

        FooterLink::create([
            FooterLink::FOOTER_ID => $model->{Footer::ID},
            FooterLink::SITE_PAGE_ID => $sitePage->{SitePage::ID},
        ]);

        return $sitePage;
    }

    #endregion
}
