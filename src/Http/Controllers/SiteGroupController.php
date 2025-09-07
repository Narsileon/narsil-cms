<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteGroupController extends AbstractController
{
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

        $collection = new DataTableCollection($query, SiteGroup::TABLE);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil::tables.site_groups'),
            description: trans('narsil::tables.site_groups'),
            props: [
                'collection' => $collection,
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

        $form = app(SiteGroupForm::class);

        $form->action = route('site-groups.store');
        $form->method = MethodEnum::POST;
        $form->submitLabel = trans('narsil::ui.create');

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
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

        $rules = app(SiteGroupFormRequest::class)->rules();

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

        $form = app(SiteGroupForm::class);

        $form->action = route('site-groups.update', $siteGroup->{SiteGroup::ID});
        $form->data = $siteGroup;
        $form->id = $siteGroup->{SiteGroup::ID};
        $form->method = MethodEnum::PATCH;
        $form->submitLabel = trans('narsil::ui.update');

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
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

        $rules = app(SiteGroupFormRequest::class)->rules($siteGroup);

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
