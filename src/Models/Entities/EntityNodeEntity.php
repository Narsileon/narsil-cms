<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
     * The name of the "target id" column.
     *
     * @var string
     */
    final public const TARGET_ID = 'target_id';

    /**
     * The name of the "target type" column.
     *
     * @var string
     */
    final public const TARGET_TYPE = 'target_type';

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
     * @return MorphTo
     */
    final public function target(): MorphTo
    {
        return $this
            ->morphTo(
                self::RELATION_TARGET,
                self::TARGET_TYPE,
                self::TARGET_ID,
                Entity::ID,
            );
    }

    #endregion

    #endregion
}
