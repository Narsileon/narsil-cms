<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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

        $templates = Template::query()
            ->withoutEagerLoads()
            ->orderBy(Template::NAME, 'asc')
            ->get();

        return $this->render(
            component: 'narsil/cms::collections/index',
            title: trans('narsil::ui.collections'),
            description: trans('narsil::ui.collections'),
            props: [
                'templates' => $templates,
            ]
        );
    }

    #endregion
}
