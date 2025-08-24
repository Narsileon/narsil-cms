<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Entities\Entity;
use Narsil\Traits\HasTableName;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class EntityEntity extends Model
{
    use HasTableName;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

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
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

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

    #region RELATIONSHIPS

    /**
     * Get the associated owner.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this
            ->belongsTo(
                Entity::class,
                self::OWNER_UUID,
                Entity::ID,
            );
    }

    /**
     * Get the associated target.
     *
     * @return BelongsTo
     */
    public function target(): BelongsTo
    {
        return $this
            ->belongsTo(
                Entity::class,
                self::TARGET_UUID,
                Entity::ID,
            );
    }

    #endregion
}
