<?php

namespace Narsil\Models\Structures;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Support\Arr;
use Narsil\Traits\HasElement;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockElement extends MorphPivot
{
    use HasElement;
    use HasTranslations;

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
            self::DESCRIPTION,
            self::NAME,
        ];

        $this->with = [
            self::RELATION_CONDITIONS,
            self::RELATION_ELEMENT,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ]);

        $this->mergeGuarded([
            self::UUID,
        ]);

        parent::__construct($attributes);

        if ($conditions = Arr::get($attributes, self::RELATION_CONDITIONS))
        {
            $this->setRelation(self::RELATION_CONDITIONS, collect($conditions));
        }

        if ($element = Arr::get($attributes, self::RELATION_ELEMENT))
        {
            $this->setRelation(self::RELATION_ELEMENT, $element);
        }
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'block_element';

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
     * The name of the "owner id" column.
     *
     * @var string
     */
    final public const OWNER_ID = 'owner_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "block" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCK = 'block';

    /**
     * The name of the "conditions" relation.
     *
     * @var string
     */
    final public const RELATION_CONDITIONS = 'conditions';

    /**
     * The name of the "field" relation.
     *
     * @var string
     */
    final public const RELATION_FIELD = 'field';

    /**
     * The name of the "owner" relation.
     *
     * @var string
     */
    final public const RELATION_OWNER = 'owner';

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
     * Get the associated conditions.
     *
     * @return HasMany
     */
    final public function conditions(): HasMany
    {
        return $this
            ->hasMany(
                BlockElementCondition::class,
                BlockElementCondition::BLOCK_ELEMENT_UUID,
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
                self::BLOCK_ID,
                Field::ID,
            );
    }

    /**
     * Get the associated owner.
     *
     * @return BelongsTo
     */
    final public function owner(): BelongsTo
    {
        return $this
            ->belongsTo(
                Block::class,
                self::OWNER_ID,
                Block::ID,
            );
    }

    #endregion

    #endregion
}
