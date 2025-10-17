<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\SiteFormRequest;
use Narsil\Http\Resources\Summaries\SiteResource;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Hosts\Host;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $collection
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Entity::class);

        $locale = App::getLocale();

        $hosts = Host::query()
            ->withoutEagerLoads()
            ->orderBy(Host::NAME . "->$locale", 'asc')
            ->get();

        $items = SiteResource::collection($hosts)
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

    /**
     * @param Request $request
     * @param string $site
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, string $site): JsonResponse|Response
    {
        return $this->render(
            component: 'narsil/cms::resources/form',
        );
    }

    /**
     * @param Request $request
     * @param string $site
     *
     * @return RedirectResponse
     */
    public function update(Request $request, string $site): RedirectResponse
    {
        $data = $request->all();

        return back()
            ->with('success', trans('narsil::toasts.success.sites.updated'));
    }

    #endregion
}
