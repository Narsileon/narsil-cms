<?php

namespace Narsil\Cms\Http\Controllers\Sites;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Response;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Http\Data\SummaryData;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Sites\Site;

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

        $items = $hosts->map(function ($host)
        {
            return new SummaryData(
                href: route('sites.edit', $host->{Host::HOSTNAME}),
                name: $host->{Host::LABEL},
            );
        });

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
        return trans('narsil-cms::ui.sites');
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil-cms::ui.sites');
    }

    #endregion
}
