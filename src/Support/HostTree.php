<?php

namespace Narsil\Support;

#region USE

use Illuminate\Support\Collection;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostPage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostTree
{
    #region CONSTRUCTOR

    /**
     * @param Host $host
     *
     * @return void
     */
    public function __construct(Host $host)
    {
        $this->collection = HostPage::query()
            ->where(HostPage::HOST_ID, $host->{Host::ID})
            ->get()
            ->groupBy(HostPage::PARENT_ID);
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Collection<string,HostPage>
     */
    protected readonly Collection $collection;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array
     */
    public function getFlatTree(): array
    {
        $hostPages = collect($this->collection->get('', []));

        $flatTree = $this->buildFlatTreeRecursively($hostPages);

        return $flatTree->toArray();
    }

    /**
     * @return array
     */
    public function getNestedTree(): array
    {
        $hostPages = collect($this->collection->get('', []));

        $nestedTree = $this->buildNestedTreeRecursively($hostPages);

        return $nestedTree->toArray();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Collection<HostPage> $collection
     *
     * @return Collection
     */
    protected function buildFlatTreeRecursively(Collection $collection): Collection
    {
        $tree = collect();

        $collection = $this->sortByNeighbors($collection);

        $collection->each(function ($hostPage) use (&$tree)
        {
            $children = $this->collection->get($hostPage->{HostPage::ID}, collect());

            $tree = $tree->merge($this->buildFlatTreeRecursively($children));

            $tree->push($hostPage);
        });

        return $tree;
    }

    /**
     * @param Collection<HostPage> $collection
     *
     * @return Collection
     */
    protected function buildNestedTreeRecursively(Collection $collection): Collection
    {
        $tree = collect();

        $collection = $this->sortByNeighbors($collection);

        $collection->each(function ($hostPage) use (&$tree)
        {
            $children = $this->collection->get($hostPage->{HostPage::ID}, collect());

            $hostPage->children = $this->buildNestedTreeRecursively($children);

            $tree->push($hostPage);
        });

        return $tree;
    }

    /**
     * @param Collection<HostPage> $collection
     *
     * @return Collection
     */
    protected function sortByNeighbors(Collection $collection): Collection
    {
        if ($collection->isEmpty())
        {
            return $collection;
        }

        $keyedCollection = $collection->keyBy(HostPage::ID);

        $sortedCollection = collect();

        $current = $collection->firstWhere(HostPage::LEFT_ID, null);

        while ($current)
        {
            $sortedCollection->push($current);

            $nextKey = $current->{HostPage::RIGHT_ID};

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
