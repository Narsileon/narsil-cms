<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\FormRequests\SiteFormRequest;
use Narsil\Contracts\Forms\SiteForm;
use Narsil\Contracts\Tables\SiteTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractResourceController;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Http\Resources\DataTableFilterCollection;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteGroup;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteController extends AbstractResourceController
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
        $query = Site::query();

        $this->filter($query, Site::GROUP_ID);

        $dataTable = new DataTableCollection($query, app(SiteTable::class));

        $dataTableFilter = new DataTableFilterCollection(
            SiteGroup::all(),
            addLabel: trans('narsil-cms::ui.add_group'),
            labelPath: SiteGroup::NAME,
            table: SiteGroup::TABLE,
        );

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil-cms::ui.sites'),
            description: trans('narsil-cms::ui.sites'),
            props: [
                'dataTable' => $dataTable,
                'dataTableFilter' => $dataTableFilter,
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request): JsonResponse|Response
    {
        $form = $this->form->get(
            url: route('sites.store'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.create'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.site'),
            description: trans('narsil-cms::ui.site'),
            props: [
                'form' => $form,
            ]
        );
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
            url: route('sites.update', $site->{Site::ID}),
            method: MethodEnum::PATCH,
            submit: trans('narsil-cms::ui.update'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.site'),
            description: trans('narsil-cms::ui.site'),
            props: [
                'data' => $site,
                'form' => $form,
            ]
        );
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
