<?php

namespace Narsil\Http\Controllers\Sites;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Http\Resources\Sites\SiteSummaryResource;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Sites\Site;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteSummaryController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $collection
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Site::class);

        $locale = App::getLocale();

        $hosts = Host::query()
            ->orderBy(Host::LABEL . "->$locale", 'asc')
            ->get();

        $items = SiteSummaryResource::collection($hosts)
            ->resolve($request);

        return $this->render('narsil/cms::summary/index', [
            'items' => $items,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil::ui.sites');
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::ui.sites');
    }

    #endregion
}
