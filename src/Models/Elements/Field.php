<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\FieldBlock;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Field extends Model
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
            self::TRANSLATABLE => 'boolean',
        ], $this->casts);

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "description" column.
     */
    final public const DESCRIPTION = 'description';
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
     * @var string The name of the "settings" column.
     */
    final public const SETTINGS = 'settings';
    /**
     * @var string The name of the "translatable" column.
     */
    final public const TRANSLATABLE = 'translatable';
    /**
     * @var string The name of the "type" column.
     */
    final public const TYPE = 'type';

    /**
     * @var string The name of the "blocks" count.
     */
    final public const COUNT_BLOCKS = 'blocks_count';

    /**
     * @var string The name of the "blocks" relation.
     */
    final public const RELATION_BLOCKS = 'blocks';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'fields';

    #endregion

    #region RELATIONS

    /**
     * @return BelongsToMany
     */
    public function blocks(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Block::class,
                FieldBlock::TABLE,
                FieldBlock::FIELD_ID,
                FieldBlock::BLOCK_ID,
            );
    }

    #endregion
}
