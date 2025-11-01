<?php

namespace Narsil\Http\Controllers\Sites;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Resources\Sites\SiteSummaryResource;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Hosts\Host;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteSummaryController extends AbstractController
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
        $this->authorize(PermissionEnum::VIEW_ANY, Entity::class);

        $locale = App::getLocale();

        $hosts = Host::query()
            ->orderBy(Host::NAME . "->$locale", 'asc')
            ->get();

        $items = SiteSummaryResource::collection($hosts)
            ->resolve($request);

        return $this->render(
            component: 'narsil/cms::summary/index',
            title: trans('narsil::ui.sites'),
            description: trans('narsil::ui.sites'),
            props: [
                'items' => $items,
            ]
        );
    }

    #endregion
}
