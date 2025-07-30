<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\Elements\Block;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockElement extends Pivot
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

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "block id" column.
     */
    final public const BLOCK_ID = 'block_id';
    /**
     * @var string The name of the "element id" column.
     */
    final public const ELEMENT_ID = 'element_id';
    /**
     * @var string The name of the "element type" column.
     */
    final public const ELEMENT_TYPE = 'element_type';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "position" column.
     */
    final public const POSITION = 'position';

    /**
     * @var string The name of the "block" relation.
     */
    final public const RELATION_Block = 'block';
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
