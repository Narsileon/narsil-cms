<?php

namespace Narsil\Models\Hosts;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class HostPage extends Model
{
    use HasTranslations;

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
    final public const TABLE = 'host_pages';

    #region • COLUMNS

    /**
     * The name of the "change freq" column.
     *
     * @var string
     */
    final public const CHANGE_FREQ = 'change_freq';

    /**
     * The name of the "host id" column.
     *
     * @var string
     */
    final public const HOST_ID = 'host_id';

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
     * The name of the "meta description" column.
     *
     * @var string
     */
    final public const META_DESCRIPTION = 'meta_description';

    /**
     * The name of the "open graph description" column.
     *
     * @var string
     */
    final public const OPEN_GRAPH_DESCRIPTION = 'open_graph_description';

    /**
     * The name of the "open graph image" column.
     *
     * @var string
     */
    final public const OPEN_GRAPH_IMAGE = 'open_graph_image';

    /**
     * The name of the "open graph title" column.
     *
     * @var string
     */
    final public const OPEN_GRAPH_TITLE = 'open_graph_title';

    /**
     * The name of the "open graph type" column.
     *
     * @var string
     */
    final public const OPEN_GRAPH_TYPE = 'open_graph_type';

    /**
     * The name of the "parent id" column.
     *
     * @var string
     */
    final public const PARENT_ID = 'parent_id';

    /**
     * The name of the "priority" column.
     *
     * @var string
     */
    final public const PRIORITY = 'priority';

    /**
     * The name of the "right id" column.
     *
     * @var string
     */
    final public const RIGHT_ID = 'right_id';

    /**
     * The name of the "robots" column.
     *
     * @var string
     */
    final public const ROBOTS = 'robots';

    /**
     * The name of the "title" column.
     *
     * @var string
     */
    final public const TITLE = 'title';


    #endregion

    #region • RELATIONS

    /**
     * The name of the "children" relation.
     *
     * @var string
     */
    final public const RELATION_CHILDREN = 'children';

    /**
     * The name of the "host" relation.
     *
     * @var string
     */
    final public const RELATION_HOST = 'host';

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
    public function children(): HasMany
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
     * Get the associated host.
     *
     * @return BelongsTo
     */
    public function host(): BelongsTo
    {
        return $this
            ->belongsTo(
                Host::class,
                self::HOST_ID,
                Host::ID
            );
    }

    /**
     * Get the node on the left.
     *
     * @return HasOne
     */
    public function left(): HasOne
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
    public function parent(): BelongsTo
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
    public function right(): HasOne
    {
        return $this
            ->hasOne(
                static::class,
                self::ID,
                self::RIGHT_ID
            );
    }

    #endregion

    #endregion
}
