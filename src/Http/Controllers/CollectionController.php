<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Resources\Summaries\CollectionSummaryResource;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CollectionController extends AbstractController
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

        $templates = Template::query()
            ->withoutEagerLoads()
            ->orderBy(Template::NAME . "->$locale", 'asc')
            ->get();

        $items = CollectionSummaryResource::collection($templates)
            ->resolve($request);

        return $this->render(
            component: 'narsil/cms::summary/index',
            title: trans('narsil::ui.collections'),
            description: trans('narsil::ui.collections'),
            props: [
                'items' => $items,
            ]
        );
    }

    #endregion
}
