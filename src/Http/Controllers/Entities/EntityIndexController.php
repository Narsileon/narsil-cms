<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Controllers\Entities;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Controllers\RenderController;
use Narsil\Cms\Http\Collections\DataTableCollection;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Traits\IsCollectionController;

#endregion

class EntityIndexController extends RenderController
{
    use IsCollectionController;

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param integer|string $collection
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function __invoke(Request $request, int|string $collection): JsonResponse|View
    {
        $this->authorize(AbilityEnum::VIEW_ANY, $this->entityClass);

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
            ->setRevisionable(true);

        return $this->renderBlade('narsil::pages.resources.index', [
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
