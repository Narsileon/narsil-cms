<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Block;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldBlock extends Pivot
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
     * @var string The name of the "field id" column.
     */
    final public const FIELD_ID = 'field_id';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';

    /**
     * @var string The name of the "block" relation.
     */
    final public const RELATION_BLOCK = 'block';
    /**
     * @var string The name of the "field" relation.
     */
    final public const RELATION_FIELD = 'field';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'field_block';

    #endregion

    #region RELATIONS

    /**
     * @return BelongsTo
     */
    public function block(): BelongsTo
    {
        return $this->belongsTo(
            Block::class,
            self::BLOCK_ID,
            Block::ID,
        );
    }

    /**
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
}
