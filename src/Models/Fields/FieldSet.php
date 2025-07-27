<?php

namespace Narsil\Models\Fields;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldSet extends Pivot
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
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "field id" column.
     */
    final public const FIELD_ID = 'field_id';
    /**
     * @var string The name of the "set id" column.
     */
    final public const SET_ID = 'set_id';

    /**
     * @var string The name of the "field" relation.
     */
    final public const RELATION_FIELD = 'field';
    /**
     * @var string The name of the "set" relation.
     */
    final public const RELATION_SET = 'set';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'field_set';

    #endregion

    #region RELATIONS

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

    /**
     * @return BelongsTo
     */
    public function set(): BelongsTo
    {
        return $this
            ->belongsTo(
                Field::class,
                self::SET_ID,
                Field::ID,
            );
    }

    #endregion
}
