<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Collections\DataTableCollection;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityIndexController extends RenderController
{
    use IsCollectionController;

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
                Entity::RELATION_DRAFT,
                Entity::RELATION_EDITOR,
                Entity::RELATION_PUBLISHED_REVISION,
                Entity::RELATION_REMOVER,
            ])
            ->where(Entity::REVISION, '>', 0);

        $collection = new DataTableCollection($query, $template->{Template::HANDLE})
            ->setRevisionable(true)
            ->toResponse($request)
            ->getData(true);

        return $this->render('narsil/cms::resources/index', [
            'collection' => $collection,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        $template = Entity::getTemplate();

        return $template->{Template::NAME};
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        $template = Entity::getTemplate();

        return $template->{Template::NAME};
    }

    #endregion
}
