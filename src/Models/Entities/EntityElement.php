<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Elements\Block;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityElement extends Model
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
     * @var string The name of the "entity uuid" column.
     */
    final public const ENTITY_UUID = 'entity_uuid';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "parent id" column.
     */
    final public const PARENT_ID = 'parent_id';
    /**
     * @var string The name of the "position" column.
     */
    final public const POSITION = 'position';
    /**
     * @var string The name of the "values" column.
     */
    final public const VALUES = 'values';

    /**
     * @var string The name of the "block" relation.
     */
    final public const RELATION_BLOCK = 'block';
    /**
     * @var string The name of the "entity" relation.
     */
    final public const RELATION_ENTITY = 'entity';
    /**
     * @var string The name of the "parent" relation.
     */
    final public const RELATION_PARENT = 'parent';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'entity_elements';

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
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this
            ->belongsTo(
                EntityElement::class,
                self::PARENT_ID,
                EntityElement::ID,
            );
    }

    #endregion
}
