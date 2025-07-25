<?php

namespace Narsil\Models\Fields;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldSetField extends Model
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
     * @var string The name of the "field id" column.
     */
    final public const FIELD_ID = 'field_id';
    /**
     * @var string The name of the "set id" column.
     */
    final public const FIELD_SET_ID = 'field_set_id';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "width" column.
     */
    final public const WIDTH = 'width';

    /**
     * @var string The name of the "conditions" relation.
     */
    final public const CONDITIONS = 'conditions';
    /**
     * @var string The name of the "field" relation.
     */
    final public const RELATION_FIELD = 'field';
    /**
     * @var string The name of the "field set" relation.
     */
    final public const RELATION_FIELD_SET = 'field_set';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'field_set_field';

    #endregion

    #region RELATIONS

    /**
     * @return HasMany
     */
    final public function conditions(): HasMany
    {
        return $this->hasMany(
            FieldCondition::class,
            FieldCondition::OWNER_ID,
            self::ID
        );
    }

    /**
     * @return BelongsTo
     */
    final public function field(): BelongsTo
    {
        return $this->belongsTo(
            Field::class,
            self::FIELD_ID,
            Field::ID,
        );
    }

    /**
     * @return BelongsTo
     */
    final public function field_set(): BelongsTo
    {
        return $this->belongsTo(
            FieldSet::class,
            self::FIELD_SET_ID,
            FieldSet::ID,
        );
    }

    #endregion
}
