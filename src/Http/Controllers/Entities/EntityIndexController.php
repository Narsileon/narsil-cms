<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Collections\DataTableCollection;
use Narsil\Http\Controllers\AbstractEntityController;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityIndexController extends AbstractEntityController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param integer|string $collection
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, int|string $collection): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Entity::class);

        $template = Entity::getTemplate();

        $query = Entity::query()
            ->with([
                Entity::RELATION_CREATOR,
                Entity::RELATION_EDITOR,
                Entity::RELATION_REMOVER,
            ]);

        $collection = new DataTableCollection($query, $template->{Template::HANDLE})
            ->setRevisionable(true)
            ->toResponse($request)
            ->getData(true);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: $template->{Template::NAME},
            description: $template->{Template::NAME},
            props: [
                'collection' => $collection,
            ]
        );
    }

    #endregion
}
