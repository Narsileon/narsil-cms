<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockElementCondition extends Model
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

        $this->with = array_merge([
            self::RELATION_TARGET,
        ], $this->with);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "operator" column.
     */
    final public const OPERATOR = 'operator';
    /**
     * @var string The name of the "owner id" column.
     */
    final public const OWNER_ID = 'owner_id';
    /**
     * @var string The name of the "target id" column.
     */
    final public const TARGET_ID = 'target_id';
    /**
     * @var string The name of the "value" column.
     */
    final public const VALUE = 'value';

    /**
     * @var string The name of the "owner" relation.
     */
    final public const RELATION_OWNER = 'owner';
    /**
     * @var string The name of the "target" relation.
     */
    final public const RELATION_TARGET = 'target';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'block_element_conditions';

    #endregion

    #region RELATIONS

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this
            ->belongsTo(
                Field::class,
                self::OWNER_ID,
                Field::ID,
            );
    }

    /**
     * @return BelongsTo
     */
    public function target(): BelongsTo
    {
        return $this
            ->belongsTo(
                Field::class,
                self::TARGET_ID,
                Field::ID,
            );
    }

    #endregion
}
