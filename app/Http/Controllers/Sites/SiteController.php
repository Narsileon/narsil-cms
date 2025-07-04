<?php

namespace App\Http\Controllers\Sites;

#region USE

use App\Http\Resources\DataTableCollection;
use App\Models\Sites\Site;
use App\Models\Sites\SiteGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $groups = new DataTableCollection(SiteGroup::query(), SiteGroup::TABLE);
        $sites = new DataTableCollection(Site::query(), Site::TABLE);

        return Inertia::render('sites/index', [
            "groups" => $groups,
            "sites" => $sites,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        return Inertia::render('sites/form');
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validated();

        Site::create($attributes);

        return redirect(route('sites.index'))
            ->with('success', 'models.sites.events.created');
    }

    /**
     * @param Request $request
     * @param Site $site
     *
     * @return Response
     */
    public function edit(Request $request, Site $site): Response
    {
        return Inertia::render('sites/form', [
            'site' => $site,
        ]);
    }

    /**
     * @param Request $request
     * @param Site $site
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Site $site): RedirectResponse
    {
        $attributes = $request->validated();

        $site->update($attributes);

        return redirect(route('sites.index'))
            ->with('success', 'models.sites.events.updated');
    }

    /**
     * @param Request $request
     * @param Site $site
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Site $site): RedirectResponse
    {
        $site->delete();

        return redirect(route('sites.index'))
            ->with('success', 'models.sites.events.deleted');
    }

    #endregion
}
