<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Narsil\Casts\JsonCast;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Traits\HasTemplate;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class EntityBlockField extends Model
{
    use HasTemplate;
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

        $this->mergeCasts([
            self::VALUE => JsonCast::class,
        ]);

        $this->mergeGuarded([
            self::UUID,
        ]);

        $this->with = array_merge([
            self::RELATION_FIELD,
        ], $this->with);

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
     * The name of the "block uuid" column.
     *
     * @var string
     */
    final public const BLOCK_UUID = 'block_uuid';

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

    /**
     * {@inheritDoc}
     */
    public static function getTableName(): string
    {
        $singular = Str::singular(static::$template?->{Template::HANDLE} ?? "");

        return $singular . '_block_fields';
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated block.
     *
     * @return BelongsTo
     */
    public function block(): BelongsTo
    {
        return $this
            ->belongsTo(
                EntityBlock::class,
                self::BLOCK_UUID,
                EntityBlock::UUID,
            );
    }

    /**
     * Get the associated field.
     *
     * @return BelongsTo
     */
    public function field(): BelongsTo
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
