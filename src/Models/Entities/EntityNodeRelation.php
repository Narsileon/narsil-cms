<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Narsil\Traits\HasUuidKey;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityNodeRelation extends Pivot
{
    use HasUuidKey;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = static::TABLE;

        $this->timestamps = false;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public const TABLE = 'entity_node_relation';

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
                static::entityClass(),
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
                static::entityNodeClass(),
                self::OWNER_NODE_UUID,
                EntityNode::UUID,
            );
    }

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

    #region PROTECTED METHODS

    /**
     * Get the class of the entity.
     *
     * @return string
     */
    protected static function entityClass(): string
    {
        return preg_replace('/NodeRelation$/', '', static::class);
    }


    /**
     * Get the class of the entity node.
     *
     * @return string
     */
    protected static function entityNodeClass(): string
    {
        return preg_replace('/Relation$/', '', static::class);
    }

    /**
     * {@inheritDoc}
     */
    protected static function booted(): void
    {
        static::saving(function (EntityNodeRelation $model)
        {
            $model->{self::LANGUAGE} ??= Config::get('app.locale');

            if (!$model->{self::TARGET_TYPE} || !$model->{self::TARGET_ID})
            {
                return;
            }

            $table = $model->{self::TARGET_TYPE};
            $column = Str::snake(Str::singular($table)) . '_id';

            $model->{$column} = $model->{self::TARGET_ID};

            if (!Schema::hasColumn($model->getTable(), $column))
            {
                try
                {
                    Schema::table($model->getTable(), function (Blueprint $blueprint) use ($column, $table)
                    {
                        $blueprint
                            ->foreignId($column)
                            ->nullable()
                            ->constrained($table, 'id')
                            ->cascadeOnDelete();
                    });
                }
                catch (QueryException $exception)
                {
                    //
                }
            }
        });
    }

    #endregion

    #endregion
}
