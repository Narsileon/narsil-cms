<?php

namespace Narsil\Models\Collections;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldBlock extends Pivot
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
    final public const TABLE = 'field_block';

    #region • COLUMNS

    /**
     * The name of the "block id" column.
     *
     * @var string
     */
    final public const BLOCK_ID = 'block_id';

    /**
     * The name of the "field id" column.
     *
     * @var string
     */
    final public const FIELD_ID = 'field_id';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "block" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCK = 'block';

    /**
     * The name of the "field" relation.
     *
     * @var string
     */
    final public const RELATION_FIELD = 'field';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated block.
     *
     * @return BelongsTo
     */
    final public function block(): BelongsTo
    {
        return $this
            ->belongsTo(
                Block::class,
                self::BLOCK_ID,
                Block::ID,
            );
    }

    /**
     * Get the associated field.
     *
     * @return BelongsTo
     */
    final public function field(): BelongsTo
    {
        return $this
            ->belongsTo(
                Field::class,
                self::FIELD_ID,
                Field::ID,
            );
    }

    #endregion

    #endregion
}
