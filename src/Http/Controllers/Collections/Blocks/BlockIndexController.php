<?php

namespace Narsil\Http\Controllers\Collections\Blocks;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Collections\DataTableCollection;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Collections\Block;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockIndexController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Block::class);

        $collection = $this->getCollection();

        return $this->render('narsil/cms::resources/index', [
            'collection' => $collection,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated collection.
     *
     * @return DataTableCollection
     */
    protected function getCollection(): DataTableCollection
    {
        $query = Block::query()
            ->with([
                Block::RELATION_BLOCKS,
                Block::RELATION_FIELDS,
            ])
            ->withCount([
                Block::RELATION_BLOCKS,
                Block::RELATION_FIELDS,
            ]);

        return new DataTableCollection($query, Block::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getTableLabel(Block::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getTableLabel(Block::TABLE);
    }

    #endregion
}
