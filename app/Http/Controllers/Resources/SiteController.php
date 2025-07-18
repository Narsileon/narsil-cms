<?php

namespace App\Http\Controllers\Resources;

#region USE

use App\Contracts\FormRequests\Resources\SiteFormRequest;
use App\Contracts\Forms\Resources\SiteForm;
use App\Enums\Forms\MethodEnum;
use App\Http\Controllers\AbstractModelController;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\DataTableCollection;
use App\Models\Sites\Site;
use App\Models\Sites\SiteGroup;
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
     * @param SiteForm $form
     * @param SiteFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(SiteForm $form, SiteFormRequest $formRequest)
    {
        $this->form = $form;
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var SiteForm
     */
    protected readonly SiteForm $form;
    /**
     * @var SiteFormRequest
     */
    protected readonly SiteFormRequest $formRequest;

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
        $form = $this->form->get(
            action: route('sites.store'),
            method: MethodEnum::POST,
            submit: trans('ui.create'),
        );

        return Narsil::render('resources/form', [
            'form' => $form,
            'title' => trans('ui.site'),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

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
        $form = $this->form->get(
            action: route('sites.update', $site->{Site::ID}),
            method: MethodEnum::PATCH,
            submit: trans('ui.update'),
        );

        return Narsil::render('resources/form', [
            'data' => $site,
            'form' => $form,
            'title' => trans('ui.site'),
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
        $attributes = $this->getAttributes($this->formRequest->rules());

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
