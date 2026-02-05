<?php

namespace Narsil\Cms\Support;

#region USE

use Illuminate\Support\Collection;
use Narsil\Cms\Models\TreeModel;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Tree
{
    #region CONSTRUCTOR

    /**
     * @param Collection<TreeModel> $collection
     *
     * @return void
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection->groupBy(TreeModel::PARENT_ID);
    }

    #endregion

    #region PROPERTIES

    /**
     * A collection of models grouped by parent id.
     *
     * @var Collection<integer,TreeModel>
     */
    protected readonly Collection $collection;

    #endregion

    #region PUBLIC METHODS

    /**
     * Get the flat tree.
     *
     * @return Collection<TreeModel>
     */
    public function getFlatTree(): Collection
    {
        $nodes = collect($this->collection->get('', []));

        $flatTree = $this->buildFlatTreeRecursively($nodes);

        return $flatTree;
    }

    /**
     * Get the nested tree.
     *
     * @return Collection<TreeModel>
     */
    public function getNestedTree(): Collection
    {
        $nodes = collect($this->collection->get('', []));

        $nestedTree = $this->buildNestedTreeRecursively($nodes);

        return $nestedTree;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Build a flat tree.
     *
     * @param Collection<TreeModel> $collection
     * @param int $depth
     *
     * @return Collection
     */
    protected function buildFlatTreeRecursively(Collection $collection, int $depth = 0): Collection
    {
        $tree = collect();

        $collection = $this->sortByNeighbors($collection);

        $collection->each(function ($model) use (&$tree, $depth)
        {
            $children = $this->collection->get($model->{TreeModel::ID}, collect());

            $model->{TreeModel::ATTRIBUTE_DEPTH} = $depth;
            $model->{TreeModel::COUNT_CHILDREN} = $children;

            $tree->push($model);

            $tree = $tree->merge($this->buildFlatTreeRecursively($children, $depth + 1));
        });

        return $tree;
    }

    /**
     * Build a nested tree.
     *
     * @param Collection<TreeModel> $collection
     *
     * @return Collection
     */
    protected function buildNestedTreeRecursively(Collection $collection): Collection
    {
        $tree = collect();

        $collection = $this->sortByNeighbors($collection);

        $collection->each(function ($model) use (&$tree)
        {
            $children = $this->collection->get($model->{TreeModel::ID}, collect());

            $model->{TreeModel::RELATION_CHILDREN} = $this->buildNestedTreeRecursively($children);

            $tree->push($model);
        });

        return $tree;
    }

    /**
     * Sort by neighbors.
     *
     * @param Collection<TreeModel> $collection
     *
     * @return Collection
     */
    protected function sortByNeighbors(Collection $collection): Collection
    {
        if ($collection->isEmpty())
        {
            return $collection;
        }

        $sortedCollection = collect();

        $current = $collection->firstWhere(TreeModel::LEFT_ID, null);

        while ($current)
        {
            $sortedCollection->push($current);

            $current = $collection->firstWhere(TreeModel::LEFT_ID, $current->{TreeModel::ID});
        }

        if ($sortedCollection->count() < $collection->count())
        {
            $remainingItems = $collection->diff($sortedCollection);

            $sortedCollection = $sortedCollection->merge($remainingItems);
        }

        return $sortedCollection;
    }

    #endregion
}
