<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Response;
use Narsil\Contracts\FormRequests\SiteFormRequest;
use Narsil\Contracts\Forms\SiteForm;
use Narsil\Contracts\Tables\SiteTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Http\Resources\DataTableFilterCollection;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteGroup;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteController extends AbstractController
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
        $this->authorize(PermissionEnum::VIEW_ANY, Site::class);

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
        $this->authorize(PermissionEnum::CREATE, Site::class);

        $this->form->method = MethodEnum::POST;
        $this->form->url = route('sites.store');

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
        $this->authorize(PermissionEnum::CREATE, Site::class);

        $data = $request->all();
        $rules = $this->formRequest->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        Site::create($attributes);

        return $this
            ->redirect(route('sites.index'))
            ->with('success', trans('narsil-cms::toasts.success.sites.created'));
    }

    /**
     * @param Request $request
     * @param Site $site
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Site $site): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $site);

        $this->form->method = MethodEnum::PATCH;
        $this->form->url = route('sites.update', [
            Str::singular(Site::TABLE) => $site->{Site::ID}
        ]);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: array_merge($this->form->jsonSerialize(), [
                'data' => $site,
            ]),
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
        $this->authorize(PermissionEnum::UPDATE, $site);

        $data = $request->all();
        $rules = $this->formRequest->rules($site);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $site->update($attributes);

        return $this
            ->redirect(route('sites.index'))
            ->with('success', trans('narsil-cms::toasts.success.sites.updated'));
    }

    /**
     * @param Request $request
     * @param Site $site
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Site $site): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $site);

        $site->delete();

        return $this
            ->redirect(route('sites.index'))
            ->with('success', trans('narsil-cms::toasts.success.sites.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Site::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Site::whereIn(Site::ID, $ids)->delete();

        return $this
            ->redirect(route('sites.index'))
            ->with('success', trans('narsil-cms::toasts.success.sites.deleted_many'));
    }

    #endregion
}
