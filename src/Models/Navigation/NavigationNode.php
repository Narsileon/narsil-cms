<?php

namespace Narsil\Models\Navigation;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class NavigationNode extends Model
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'navigation_nodes';

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

    #region RELATIONSHIPS

    /**
     * Get the associated children.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(
            static::class,
            self::PARENT_ID,
            self::ID
        );
    }

    /**
     * Get the node on the left.
     *
     * @return HasOne
     */
    public function left(): HasOne
    {
        return $this->hasOne(
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
    public function parent(): BelongsTo
    {
        return $this->belongsTo(
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
    public function right(): HasOne
    {
        return $this->hasOne(
            static::class,
            self::ID,
            self::RIGHT_ID
        );
    }

    #endregion

    #endregion
}
