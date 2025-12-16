<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Narsil\Models\Elements\Template;
use Narsil\Traits\HasTemplate;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityFieldBlock extends Model
{
    use HasTemplate;
    use HasTranslations;
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = static::getTableName();

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
    final public const TABLE = 'entity_field_block';

    #region • COLUMNS

    /**
     * The name of the "entity block uuid" column.
     *
     * @var string
     */
    final public const ENTITY_BLOCK_UUID = 'entity_block_uuid';

    /**
     * The name of the "entity block field uuid" column.
     *
     * @var string
     */
    final public const ENTITY_BLOCK_FIELD_UUID = 'entity_block_field_uuid';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "entity blocks" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY_BLOCKS = 'entity_blocks';

    /**
     * The name of the "entity field" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY_FIELD = 'entity_field';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    final public static function getTableName(): string
    {
        $singular = Str::singular(static::$template?->{Template::HANDLE} ?? "");

        return $singular . '_field_block';
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated entity block.
     *
     * @return BelongsTo
     */
    final public function entity_blocks(): BelongsTo
    {
        return $this
            ->belongsTo(
                EntityBlock::class,
                self::ENTITY_BLOCK_UUID,
                EntityBlock::UUID,
            );
    }

    /**
     * Get the associated entity field.
     *
     * @return BelongsTo
     */
    final public function entity_field(): BelongsTo
    {
        return $this
            ->belongsTo(
                EntityBlockField::class,
                self::ENTITY_BLOCK_FIELD_UUID,
                EntityBlockField::UUID,
            );
    }

    #endregion

    #endregion
}
