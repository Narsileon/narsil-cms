<?php

namespace App\Http\Controllers\Sites;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Http\Controllers\AbstractModelController;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\DataTableCollection;
use App\Interfaces\Forms\ISiteForm;
use App\Models\Site;
use App\Models\SiteGroup;
use App\Narsil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteController extends AbstractModelController
{
    #region CONSTRUCTOR

    /**
     * @param ISiteForm $form
     *
     * @return void
     */
    public function __construct(ISiteForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var ISiteForm
     */
    protected readonly ISiteForm $form;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $categories = new CategoryCollection(SiteGroup::all(), SiteGroup::TABLE, SiteGroup::NAME);
        $dataTable = new DataTableCollection(Site::query(), Site::TABLE);

        return Narsil::render('resources/index', [
            'categories' => $categories,
            'dataTable' => $dataTable,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request): JsonResponse|Response
    {
        $form = $this->form::get(
            action: route('sites.store'),
            method: MethodEnum::POST,
            submit: trans('ui.create'),
        );

        return Narsil::render('resources/form', [
            'form' => $form,
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
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Site $site): JsonResponse|Response
    {
        $form = $this->form::get(
            action: route('sites.update', $site->{Site::ID}),
            method: MethodEnum::PATCH,
            submit: trans('ui.update'),
        );

        return Narsil::render('resources/form', [
            'data' => $site,
            'form' => $form,
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
