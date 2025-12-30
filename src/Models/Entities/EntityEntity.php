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
class EntityEntity extends Pivot
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

        $this->with = [
            self::RELATION_TARGET,
        ];

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
    final public const TABLE = 'entity_entity';

    #region • COLUMNS

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
