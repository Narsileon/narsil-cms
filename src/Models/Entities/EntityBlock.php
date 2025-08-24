<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Elements\Block;
use Narsil\Models\Entities\Entity;
use Narsil\Traits\HasTableName;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class EntityBlock extends Model
{
    use HasTableName;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
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
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'entity_elements';

    #region • COLUMNS

    /**
     * The name of the "block id" column.
     *
     * @var string
     */
    final public const BLOCK_ID = 'block_id';

    /**
     * The name of the "entity uuid" column.
     *
     * @var string
     */
    final public const ENTITY_UUID = 'entity_uuid';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "parent id" column.
     *
     * @var string
     */
    final public const PARENT_ID = 'parent_id';

    /**
     * The name of the "position" column.
     *
     * @var string
     */
    final public const POSITION = 'position';

    /**
     * The name of the "values" column.
     *
     * @var string
     */
    final public const VALUES = 'values';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "block" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCK = 'block';

    /**
     * The name of the "entity" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY = 'entity';

    /**
     * The name of the "parent" relation.
     *
     * @var string
     */
    final public const RELATION_PARENT = 'parent';

    #endregion

    #endregion

    #region RELATIONSHIPS

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
     * Get the associated entity.
     *
     * @return BelongsTo
     */
    public function entity(): BelongsTo
    {
        return $this
            ->belongsTo(
                Entity::class,
                self::ENTITY_UUID,
                Entity::ID,
            );
    }

    /**
     * Get the associated parent.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this
            ->belongsTo(
                self::class,
                self::PARENT_ID,
                self::ID,
            );
    }

    #endregion
}
