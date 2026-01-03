<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractEntityNodeRelation extends Pivot
{
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->primaryKey = self::UUID;
        $this->timestamps = false;

        $this->mergeGuarded([
            self::UUID,
        ]);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    #region • COLUMNS

    /**
     * The name of the "entity uuid" column.
     *
     * @var string
     */
    final public const ENTITY_UUID = 'entity_uuid';

    /**
     * The name of the "entity node uuid" column.
     *
     * @var string
     */
    final public const ENTITY_NODE_UUID = 'entity_node_uuid';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "entity" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY = 'entity';

    /**
     * The name of the "entity field" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY_NODE = 'entity_node';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated entity.
     *
     * @return BelongsTo
     */
    final public function entity(): BelongsTo
    {
        return $this
            ->belongsTo(
                Entity::class,
                self::ENTITY_UUID,
                Entity::UUID,
            );
    }

    /**
     * Get the associated entity node.
     *
     * @return BelongsTo
     */
    final public function entity_node(): BelongsTo
    {
        return $this
            ->belongsTo(
                EntityNode::class,
                self::ENTITY_NODE_UUID,
                EntityNode::UUID,
            );
    }

    #endregion

    #endregion
}
