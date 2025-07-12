<?php

namespace App\Http\Controllers\Sites;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Http\Controllers\AbstractModelController;
use App\Http\Forms\SiteGroupForm;
use App\Http\Resources\DataTableCollection;
use App\Models\SiteGroup;
use App\Narsil;
use App\Services\FormService;
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
            "dataTable" => $dataTable,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request): JsonResponse|Response
    {
        $form = (FormService::getForm(SiteGroup::TABLE))::get(
            action: route('site-groups.store'),
            method: MethodEnum::POST,
            submit: trans("ui.create"),
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
        $attributes = $this->getAttributes(SiteGroup::TABLE);

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
        $form = (FormService::getForm(SiteGroup::TABLE))::get(
            action: route('site-groups.update', $siteGroup->{SiteGroup::ID}),
            method: MethodEnum::PATCH,
            submit: trans("ui.update"),
        );

        return Narsil::render('resources/form', [
            'data' => $siteGroup,
            'form' => $form,
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
        $attributes = $this->getAttributes(SiteGroup::TABLE);

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
