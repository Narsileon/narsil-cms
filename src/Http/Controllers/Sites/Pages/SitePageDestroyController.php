<?php

namespace Narsil\Http\Controllers\Sites\Pages;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageDestroyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $site
     * @param SitePage $sitePage
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, string $site, SitePage $sitePage): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $sitePage);

        $this->updateNeighbors($sitePage);

        $this->deleteRecursively($sitePage);

        return redirect(route('sites.edit', $site))
            ->with('success', trans('narsil::toasts.success.site_pages.deleted'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param SitePage $sitePage
     *
     * @return void
     */
    final protected function deleteRecursively(SitePage $sitePage): void
    {
        $sitePage->loadMissing([
            SitePage::RELATION_CHILDREN,
        ]);

        foreach ($sitePage->{SitePage::RELATION_CHILDREN} as $child)
        {
            $this->deleteRecursively($child, false);
        }

        $sitePage->children()->delete();

        $sitePage->delete();
    }

    /**
     * @param SitePage $sitePage
     *
     * @return void
     */
    final protected function updateNeighbors(SitePage $sitePage): void
    {
        $sitePage->loadMissing([
            SitePage::RELATION_LEFT,
            SitePage::RELATION_RIGHT,
        ]);

        SitePage::query()
            ->where(SitePage::LEFT_ID, $sitePage->{SitePage::ID})
            ->update([
                SitePage::LEFT_ID => $sitePage->{SitePage::RELATION_LEFT}?->{SitePage::ID},
            ]);

        SitePage::query()
            ->where(SitePage::RIGHT_ID, $sitePage->{SitePage::ID})
            ->update([
                SitePage::RIGHT_ID => $sitePage->{SitePage::RELATION_RIGHT}?->{SitePage::ID},
            ]);
    }

    #endregion
}
