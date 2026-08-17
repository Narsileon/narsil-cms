<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Menus;

#region USE

use Narsil\Base\Contracts\Menus\Home as Contract;
use Narsil\Base\Implementations\Menus\Home as BaseHome;
use Narsil\Base\Support\MenuItem;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

final class Home extends BaseHome implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        $this->addHomeItem();

        $this
            ->add(
                new MenuItem('cms')->icon('chart-pie')
                    ->label('CMS')
                    ->route('dashboard')
            );

        $site = Site::query()
            ->orderBy(Site::LABEL)
            ->first();

        if ($site)
        {
            $sitePage = SitePage::query()
                ->where(SitePage::SITE_ID, $site->{Site::ID})
                ->where(SitePage::COUNTRY, 'default')
                ->whereNull(SitePage::PARENT_ID)
                ->orderBy(SitePage::LEFT_ID)
                ->first();

            if ($sitePage)
            {
                $this->add(
                    new MenuItem('live-editor')->icon('edit')
                        ->label(trans('narsil-cms::live-editor.title'))
                        ->route('live-editor.show')
                        ->parameters([
                            'sitePage' => $sitePage->{SitePage::ID},
                        ])
                );
            }
        }

        return parent::content();
    }

    #endregion
}
