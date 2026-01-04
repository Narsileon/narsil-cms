<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Config;

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
     * The name of the "language" column.
     *
     * @var string
     */
    final public const LANGUAGE = 'language';

    /**
     * The name of the "owner uuid" column.
     *
     * @var string
     */
    final public const OWNER_UUID = 'owner_uuid';

    /**
     * The name of the "owner node uuid" column.
     *
     * @var string
     */
    final public const OWNER_NODE_UUID = 'owner_node_uuid';

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
     * The name of the "owner node" relation.
     *
     * @var string
     */
    final public const RELATION_OWNER_NODE = 'owner_node';

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
     * Get the associated owner node.
     *
     * @return BelongsTo
     */
    final public function owner_node(): BelongsTo
    {
        return $this
            ->belongsTo(
                EntityNode::class,
                self::OWNER_NODE_UUID,
                EntityNode::UUID,
            );
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected static function booted(): void
    {
        static::saving(function (AbstractEntityNodeRelation $model)
        {
            if (!$model->{EntityNodeEntity::LANGUAGE})
            {
                $model->{EntityNodeEntity::LANGUAGE} = Config::get('app.locale');
            }
        });
    }

    #endregion
}
