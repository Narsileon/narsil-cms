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
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockElement extends Model
{
    use HasElement;

    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
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
     * @var string The name of the "block id" column.
     */
    final public const BLOCK_ID = 'block_id';

    /**
     * @var string The name of the "counditions" count.
     */
    final public const COUNT_CONDITIONS = 'conditions_count';

    /**
     * @var string The name of the "block" relation.
     */
    final public const RELATION_BLOCK = 'block';
    /**
     * @var string The name of the "conditions" relation.
     */
    final public const RELATION_CONDITIONS = 'conditions';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'block_element';

    #endregion

    #region RELATIONS

    /**
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
}
