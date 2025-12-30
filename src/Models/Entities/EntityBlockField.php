<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Casts\JsonCast;
use Narsil\Models\Structures\Field;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityBlockField extends Model
{
    use HasTranslations;
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

        $this->translatable = [
            self::VALUE,
        ];

        $this->with = [
            self::RELATION_BLOCKS,
            self::RELATION_FIELD,
        ];

        $this->mergeCasts([
            self::VALUE => JsonCast::class,
        ]);

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
    final public const TABLE = 'entity_block_fields';

    #region • COLUMNS

    /**
     * The name of the "entity block uuid" column.
     *
     * @var string
     */
    final public const ENTITY_BLOCK_UUID = 'block_uuid';

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

    /**
     * The name of the "value" column.
     *
     * @var string
     */
    final public const VALUE = 'value';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "blocks" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCKS = 'blocks';

    /**
     * The name of the "entity block" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY_BLOCK = 'entity_block';

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
    final public function entity_block(): BelongsTo
    {
        return $this
            ->belongsTo(
                EntityBlock::class,
                self::ENTITY_BLOCK_UUID,
                EntityBlock::UUID,
            );
    }

    /**
     * Get the associated blocks.
     *
     * @return HasMany
     */
    public function blocks(): HasMany
    {
        return $this->hasMany(
            EntityBlock::class,
            EntityBlock::ENTITY_FIELD_UUID,
            self::UUID,
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
