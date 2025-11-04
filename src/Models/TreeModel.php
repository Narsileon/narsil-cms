<?php

namespace Narsil\Models;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class TreeModel extends Model
{
    #region CONSTANTS

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "left id" column.
     *
     * @var string
     */
    final public const LEFT_ID = 'left_id';

    /**
     * The name of the "parent id" column.
     *
     * @var string
     */
    final public const PARENT_ID = 'parent_id';

    /**
     * The name of the "right id" column.
     *
     * @var string
     */
    final public const RIGHT_ID = 'right_id';


    #endregion

    #region • ATTRIBUTES

    /**
     * The name of the "depth" relation.
     *
     * @var string
     */
    final public const ATTRIBUTE_DEPTH = 'depth';

    #endregion

    #region • COUNTS

    /**
     * The name of the "children" count.
     *
     * @var string
     */
    final public const COUNT_CHILDREN = 'children_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "children" relation.
     *
     * @var string
     */
    final public const RELATION_CHILDREN = 'children';

    /**
     * The name of the "left" relation.
     *
     * @var string
     */
    final public const RELATION_LEFT = 'left';

    /**
     * The name of the "parent" relation.
     *
     * @var string
     */
    final public const RELATION_PARENT = 'parent';

    /**
     * The name of the "right" relation.
     *
     * @var string
     */
    final public const RELATION_RIGHT = 'right';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated children.
     *
     * @return HasMany
     */
    final public function children(): HasMany
    {
        return $this
            ->hasMany(
                static::class,
                self::PARENT_ID,
                self::ID
            )
            ->with(self::RELATION_CHILDREN);
    }

    /**
     * Get the node on the left.
     *
     * @return HasOne
     */
    final public function left(): HasOne
    {
        return $this
            ->hasOne(
                static::class,
                self::ID,
                self::LEFT_ID
            );
    }

    /**
     * Get the associated parent.
     *
     * @return BelongsTo
     */
    final public function parent(): BelongsTo
    {
        return $this
            ->belongsTo(
                static::class,
                self::PARENT_ID,
                self::ID
            );
    }

    /**
     * Get the node on the right.
     *
     * @return HasOne
     */
    final public function right(): HasOne
    {
        return $this
            ->hasOne(
                static::class,
                self::ID,
                self::RIGHT_ID
            );
    }

    #endregion

    #region • SCOPES

    /**
     * @param Builder $query
     * @param ?array $tree
     * @param string $hostLocaleUuid
     *
     * @return boolean|string
     */
    public function scopeRebuildTree(
        Builder $query,
        array $tree = [],
    ): bool|string
    {
        $collection = $query
            ->with([
                self::RELATION_LEFT,
                self::RELATION_PARENT,
                self::RELATION_RIGHT,
            ])
            ->get()
            ->keyBy(self::ID);

        static::rebuildTreeRecursively($collection, $tree);

        return true;
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Collection<integer,TreeModel> $nodes
     * @param array $data
     * @param TreeModel|null $parent
     *
     * @return void
     */
    protected static function rebuildTreeRecursively(Collection $collection, array $data, ?TreeModel $parent = null): void
    {
        $ids = collect($data)->pluck(self::ID);

        $nodes = $ids->map(function ($id) use ($collection)
        {
            return $collection->get($id);
        })->filter();

        $dataCollection = collect($data)->keyBy(self::ID);

        $nodes->each(function ($node, $index) use ($collection, $dataCollection, $nodes, $parent)
        {
            $leftAttributes = [];
            $nodeAttributes = [];

            $nodeAttributes[self::PARENT_ID] = $parent?->{self::ID};

            $isLastNode = ($index === $nodes->count() - 1);

            $left = $nodes->get($index - 1);

            if ($left)
            {
                $leftAttributes[self::RIGHT_ID] = $node->{self::ID};
                $nodeAttributes[self::LEFT_ID] = $left->{self::ID};
            }
            else
            {
                $nodeAttributes[self::LEFT_ID] = null;
            }

            if ($isLastNode)
            {
                $nodeAttributes[self::RIGHT_ID] = null;
            }

            if ($left)
            {
                $left->update($leftAttributes);
            }

            $node->update($nodeAttributes);

            if ($children = $dataCollection->get($node->{self::ID})[self::RELATION_CHILDREN] ?? null)
            {
                static::rebuildTreeRecursively($collection, $children, $node);
            }
        });
    }

    #endregion
}
