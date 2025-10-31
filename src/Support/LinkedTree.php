<?php

namespace Narsil\Support;

#region USE

use Illuminate\Support\Collection;
use Narsil\Models\TreeModel;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LinkedTree
{
    #region CONSTRUCTOR

    /**
     * @param Collection<string,TreeModel> $collection
     *
     * @return void
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Collection<string,TreeModel>
     */
    protected readonly Collection $collection;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array
     */
    public function getFlatTree(): array
    {
        $nodes = collect($this->collection->get('', []));

        $flatTree = $this->buildFlatTreeRecursively($nodes);

        return $flatTree->toArray();
    }

    /**
     * @return array
     */
    public function getNestedTree(): array
    {
        $nodes = collect($this->collection->get('', []));

        $nestedTree = $this->buildNestedTreeRecursively($nodes);

        return $nestedTree->toArray();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Collection<TreeModel> $collection
     *
     * @return Collection
     */
    protected function buildFlatTreeRecursively(Collection $collection): Collection
    {
        $tree = collect();

        $collection = $this->sortByNeighbors($collection);

        $collection->each(function ($model) use (&$tree)
        {
            $children = $this->collection->get($model->{TreeModel::ID}, collect());

            $tree = $tree->merge($this->buildFlatTreeRecursively($children));

            $tree->push($model);
        });

        return $tree;
    }

    /**
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

        $keyedCollection = $collection->keyBy(TreeModel::ID);

        $sortedCollection = collect();

        $current = $collection->firstWhere(TreeModel::LEFT_ID, null);

        while ($current)
        {
            $sortedCollection->push($current);

            $nextKey = $current->{TreeModel::RIGHT_ID};

            $current = $nextKey ? $keyedCollection->get($nextKey) : null;
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
