<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Arr;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElementCondition;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockElement extends Model
{
    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->casts = array_merge([
            self::SETTINGS => 'json',
        ], $this->casts);

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
     * @var string The name of the "description" column.
     */
    final public const DESCRIPTION = 'description';
    /**
     * @var string The name of the "element id" column.
     */
    final public const ELEMENT_ID = 'element_id';
    /**
     * @var string The name of the "element type" column.
     */
    final public const ELEMENT_TYPE = 'element_type';
    /**
     * @var string The name of the "handle" column.
     */
    final public const HANDLE = 'handle';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "name" column.
     */
    final public const NAME = 'name';
    /**
     * @var string The name of the "position" column.
     */
    final public const POSITION = 'position';
    /**
     * @var string The name of the "settings" column.
     */
    final public const SETTINGS = 'settings';

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
     * @var string The name of the "element" relation.
     */
    final public const RELATION_ELEMENT = 'element';

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

    /**
     * @return MorphTo
     */
    public function element(): MorphTo
    {
        return $this->morphTo(
            self::RELATION_ELEMENT,
            self::ELEMENT_TYPE,
            self::ELEMENT_ID,
        );
    }

    #endregion
}
