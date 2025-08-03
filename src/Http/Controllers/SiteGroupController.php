<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\FormRequests\SiteGroupFormRequest;
use Narsil\Contracts\Forms\SiteGroupForm;
use Narsil\Contracts\Tables\SiteGroupTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Sites\SiteGroup;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteGroupController extends AbstractController
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
        $query = SiteGroup::query();

        $dataTable = new DataTableCollection($query, app(SiteGroupTable::class));

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil-cms::ui.site_groups'),
            description: trans('narsil-cms::ui.site_groups'),
            props: [
                'dataTable' => $dataTable,
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
            url: route('site-groups.store'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.create'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.site_group'),
            description: trans('narsil-cms::ui.site_group'),
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

        SiteGroup::create($attributes);

        return $this
            ->redirect(route('site_groups.index'))
            ->with('success', trans('narsil-cms::toasts.success.site_groups.created'));
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
            url: route('site-groups.update', $siteGroup->{SiteGroup::ID}),
            method: MethodEnum::PATCH,
            submit: trans('narsil-cms::ui.update'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.site_group'),
            description: trans('narsil-cms::ui.site_group'),
            props: [
                'data' => $siteGroup,
                'form' => $form,
            ]
        );
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

        return $this
            ->redirect(route('site_groups.index'))
            ->with('success', trans('narsil-cms::toasts.success.site_groups.updated'));
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

        return $this
            ->redirect(route('site_groups.index'))
            ->with('success', trans('narsil-cms::toasts.success.site_groups.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $ids = $request->validated(DestroyManyRequest::IDS);

        SiteGroup::whereIn(SiteGroup::ID, $ids)->delete();

        return $this
            ->redirect(route('site-groups.index'))
            ->with('success', trans('narsil-cms::toasts.success.site_groups.deleted_many'));
    }

    #endregion
}
