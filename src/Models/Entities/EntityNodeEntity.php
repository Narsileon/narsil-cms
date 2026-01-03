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
class EntityNodeEntity extends Pivot
{
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;
        $this->timestamps = false;

        $this->mergeGuarded([
            self::UUID,
        ]);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'entity_node_entity';

    #region • COLUMNS

    /**
     * The name of the "entity field uuid" column.
     *
     * @var string
     */
    final public const ENTITY_NODE_UUID = 'entity_node_uuid';

    /**
     * The name of the "owner uuid" column.
     *
     * @var string
     */
    final public const OWNER_UUID = 'owner_uuid';

    /**
     * The name of the "target uuid" column.
     *
     * @var string
     */
    final public const TARGET_UUID = 'target_uuid';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "entity field" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY_NODE = 'entity_node';

    /**
     * The name of the "owner" relation.
     *
     * @var string
     */
    final public const RELATION_OWNER = 'owner';

    /**
     * The name of the "target" relation.
     *
     * @var string
     */
    final public const RELATION_TARGET = 'target';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated entity field.
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

    /**
     * Get the associated owner.
     *
     * @return BelongsTo
     */
    final public function owner(): BelongsTo
    {
        return $this
            ->belongsTo(
                Entity::class,
                self::OWNER_UUID,
                Entity::UUID,
            );
    }

    /**
     * Get the associated target.
     *
     * @return BelongsTo
     */
    final public function target(): BelongsTo
    {
        return $this
            ->belongsTo(
                Entity::class,
                self::TARGET_UUID,
                Entity::UUID,
            );
    }

    #endregion

    #endregion
}
