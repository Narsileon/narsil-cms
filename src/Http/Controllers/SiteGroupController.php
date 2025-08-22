<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Response;
use Narsil\Contracts\FormRequests\SiteGroupFormRequest;
use Narsil\Contracts\Forms\SiteGroupForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
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
        $this->authorize(PermissionEnum::VIEW_ANY, SiteGroup::class);

        $query = SiteGroup::query();

        $dataTable = new DataTableCollection($query, SiteGroup::TABLE);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil::tables.site_groups'),
            description: trans('narsil::tables.site_groups'),
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
        $this->authorize(PermissionEnum::CREATE, SiteGroup::class);

        $this->form->method = MethodEnum::POST;
        $this->form->url = route('site-groups.store');

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $this->form->jsonSerialize(),
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, SiteGroup::class);

        $data = $request->all();
        $rules = $this->formRequest->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        SiteGroup::create($attributes);

        return $this
            ->redirect(route('site_groups.index'))
            ->with('success', trans('narsil::toasts.success.site_groups.created'));
    }

    /**
     * @param Request $request
     * @param SiteGroup $siteGroup
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, SiteGroup $siteGroup): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $siteGroup);

        $this->form->method = MethodEnum::PATCH;
        $this->form->url = route('site-groups.update', [
            Str::singular(SiteGroup::TABLE) => $siteGroup->{SiteGroup::ID}
        ]);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: array_merge($this->form->jsonSerialize(), [
                'data' => $siteGroup,
            ]),
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
        $this->authorize(PermissionEnum::UPDATE, $siteGroup);

        $data = $request->all();
        $rules = $this->formRequest->rules($siteGroup);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $siteGroup->update($attributes);

        return $this
            ->redirect(route('site_groups.index'))
            ->with('success', trans('narsil::toasts.success.site_groups.updated'));
    }

    /**
     * @param Request $request
     * @param SiteGroup $siteGroup
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, SiteGroup $siteGroup): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $siteGroup);

        $siteGroup->delete();

        return $this
            ->redirect(route('site_groups.index'))
            ->with('success', trans('narsil::toasts.success.site_groups.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, SiteGroup::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        SiteGroup::whereIn(SiteGroup::ID, $ids)->delete();

        return $this
            ->redirect(route('site-groups.index'))
            ->with('success', trans('narsil::toasts.success.site_groups.deleted_many'));
    }

    #endregion
}
