<?php

namespace Narsil\Http\Controllers\HostPages;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Hosts\HostPage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageDestroyController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $site
     * @param HostPage $hostPage
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, string $site, HostPage $hostPage): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $hostPage);

        $this->updateNeighbors($hostPage);

        $this->deleteRecursively($hostPage);

        return redirect(route('sites.edit', $site))
            ->with('success', trans('narsil::toasts.success.host_pages.deleted'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param HostPage $hostPage
     *
     * @return void
     */
    final protected function deleteRecursively(HostPage $hostPage): void
    {
        $hostPage->loadMissing([
            HostPage::RELATION_CHILDREN,
        ]);

        foreach ($hostPage->{HostPage::RELATION_CHILDREN} as $child)
        {
            $this->deleteRecursively($child, false);
        }

        $hostPage->children()->delete();

        $hostPage->delete();
    }

    /**
     * @param HostPage $hostPage
     *
     * @return void
     */
    final protected function updateNeighbors(HostPage $hostPage): void
    {
        $hostPage->loadMissing([
            HostPage::RELATION_LEFT,
            HostPage::RELATION_RIGHT,
        ]);

        HostPage::query()
            ->where(HostPage::LEFT_ID, $hostPage->{HostPage::ID})
            ->update([
                HostPage::LEFT_ID => $hostPage->{HostPage::RELATION_LEFT}?->{HostPage::ID},
            ]);

        HostPage::query()
            ->where(HostPage::RIGHT_ID, $hostPage->{HostPage::ID})
            ->update([
                HostPage::RIGHT_ID => $hostPage->{HostPage::RELATION_RIGHT}?->{HostPage::ID},
            ]);
    }

    #endregion
}
