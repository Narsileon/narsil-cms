<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityEntity extends Model
{
    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
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
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "owner uuid" column.
     */
    final public const OWNER_UUID = 'owner_uuid';
    /**
     * @var string The name of the "target uuid" column.
     */
    final public const TARGET_UUID = 'target_uuid';

    /**
     * @var string The name of the "owner" relation.
     */
    final public const RELATION_OWNER = 'owner';
    /**
     * @var string The name of the "target" relation.
     */
    final public const RELATION_TARGET = 'target';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'entity_entity';

    #endregion

    #region RELATIONS

    /**
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
