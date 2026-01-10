<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Collections\DataTableCollection;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Collections\Template;
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
        $this->authorize(PermissionEnum::VIEW_ANY, $this->entityClass);

        $query = $this->entityClass::query()
            ->with([
                Entity::RELATION_CREATOR,
                Entity::RELATION_DRAFT,
                Entity::RELATION_EDITOR,
                Entity::RELATION_PUBLISHED_REVISION,
                Entity::RELATION_REMOVER,
            ])
            ->where(Entity::TEMPLATE_ID, $this->template->{Template::ID})
            ->where(Entity::REVISION, '>', 0);

        $collection = new DataTableCollection($query, $this->template->{Template::TABLE_NAME})
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
        return Str::ucfirst($this->template->{Template::PLURAL});
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return Str::ucfirst($this->template->{Template::PLURAL});
    }

    #endregion
}
