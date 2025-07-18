<?php

namespace App\Http\Controllers\Resources;

#region USE

use App\Contracts\FormRequests\Resources\SiteGroupFormRequest;
use App\Contracts\Forms\Resources\SiteGroupForm;
use App\Enums\Forms\MethodEnum;
use App\Http\Controllers\AbstractModelController;
use App\Http\Resources\DataTableCollection;
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
class SiteGroupController extends AbstractModelController
{
    #region CONSTRUCTOR

    /**
     * @param SiteGroupForm $form
     * @param SiteGroupFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(SiteGroupForm $form, SiteGroupFormRequest $formRequest)
    {
        $this->form = $form;
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var SiteGroupForm
     */
    protected readonly SiteGroupForm $form;
    /**
     * @var SiteFormRequest
     */
    protected readonly SiteGroupFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $dataTable = new DataTableCollection(SiteGroup::query(), SiteGroup::TABLE);

        return Narsil::render('resources/index', [
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
            action: route('site-groups.store'),
            method: MethodEnum::POST,
            submit: trans('ui.create'),
        );

        return Narsil::render('resources/form', [
            'form' => $form,
            'title' => trans('ui.site_group'),
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

        SiteGroup::create($attributes);

        return $this->redirectOnStored(SiteGroup::TABLE);
    }

    /**
     * @param Request $request
     * @param SiteGroup $siteGroup
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, SiteGroup $siteGroup): JsonResponse|Response
    {
        $form = $this->form->get(
            action: route('site-groups.update', $siteGroup->{SiteGroup::ID}),
            method: MethodEnum::PATCH,
            submit: trans('ui.update'),
        );

        return Narsil::render('resources/form', [
            'data' => $siteGroup,
            'form' => $form,
            'title' => trans('ui.site_group'),
        ]);
    }

    /**
     * @param Request $request
     * @param SiteGroup $siteGroup
     *
     * @return RedirectResponse
     */
    public function update(Request $request, SiteGroup $siteGroup): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

        $siteGroup->update($attributes);

        return $this->redirectOnUpdated(SiteGroup::TABLE);
    }

    /**
     * @param Request $request
     * @param SiteGroup $siteGroup
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, SiteGroup $siteGroup): RedirectResponse
    {
        $siteGroup->delete();

        return $this->redirectOnDestroyed(SiteGroup::TABLE);
    }

    #endregion
}
