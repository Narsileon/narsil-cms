<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityNodeEntity extends AbstractEntityNodeRelation
{
    use HasUuids;

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
    final public const TABLE = 'entity_node_entity';

    #region • COLUMNS

    /**
     * The name of the "target uuid" column.
     *
     * @var string
     */
    final public const TARGET_UUID = 'target_uuid';

    #endregion

    #region • RELATIONS

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
