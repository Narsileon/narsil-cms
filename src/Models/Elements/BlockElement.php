<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElementCondition;
use Narsil\Traits\HasElement;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class BlockElement extends Model
{
    use HasElement;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->appends = array_merge([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ], $this->appends);

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

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

    #endregion

    #endregion

    #region PUBLIC METHODS

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
    public function conditions(): HasMany
    {
        return $this
            ->hasMany(
                BlockElementCondition::class,
                BlockElementCondition::OWNER_ID,
                self::ID,
            );
    }

    #endregion

    #endregion
}
