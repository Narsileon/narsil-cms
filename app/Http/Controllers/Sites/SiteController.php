<?php

namespace App\Http\Controllers\Sites;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Http\Controllers\AbstractModelController;
use App\Http\Forms\SiteForm;
use App\Http\Resources\DataTableCollection;
use App\Models\Site;
use App\Services\FormService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteController extends AbstractModelController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $collection = new DataTableCollection(Site::query(), Site::TABLE);

        return Inertia::render('resources/index', [
            "collection" => $collection,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        $form = FormService::getForm(Site::TABLE, SiteForm::class);

        return Inertia::render('resources/form', [
            'form' => $form::get(
                action: route('sites.store'),
                method: MethodEnum::POST,
                submit: trans("ui.create"),
                title: trans("ui.site"),
            ),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $this->getAttributes(Site::TABLE);

        Site::create($attributes);

        return $this->redirectOnStored(Site::TABLE);
    }

    /**
     * @param Request $request
     * @param Site $site
     *
     * @return Response
     */
    public function edit(Request $request, Site $site): Response
    {
        $form = FormService::getForm(Site::TABLE, SiteForm::class);

        return Inertia::render('resources/form', [
            'data' => $site,
            'form' => $form::get(
                action: route('sites.update', $site->{Site::ID}),
                method: MethodEnum::PATCH,
                submit: trans("ui.update"),
                title: trans("ui.site"),
            ),
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
        $attributes = $this->getAttributes(Site::TABLE);

        $site->update($attributes);

        return $this->redirectOnUpdated(Site::TABLE);
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

        return $this->redirectOnDestroyed(Site::TABLE);
    }

    #endregion
}
