<?php

namespace Narsil\Models\Fields;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\Fields\FieldSet;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldSetElement extends Pivot
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
     * @var string The name of the "field set id" column.
     */
    final public const FIELD_SET_ID = 'field_set_id';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "element id" column.
     */
    final public const ELEMENT_ID = 'element_id';
    /**
     * @var string The name of the "item type" column.
     */
    final public const ELEMENT_TYPE = 'element_type';
    /**
     * @var string The name of the "item type" column.
     */
    final public const POSITION = 'position';

    /**
     * @var string The name of the "field set" relation.
     */
    final public const RELATION_FIELD_SET = 'field_set';
    /**
     * @var string The name of the "element" relation.
     */
    final public const RELATION_ELEMENT = 'element';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'field_set_element';

    #endregion

    #region RELATIONS

    /**
     * @return BelongsTo
     */
    public function field_set(): BelongsTo
    {
        return $this
            ->belongsTo(
                FieldSet::class,
                self::FIELD_SET_ID,
                FieldSet::ID,
            );
    }

    /**
     * @return MorphTo
     */
    public function item(): MorphTo
    {
        return $this->morphTo(
            self::RELATION_ELEMENT,
            self::ELEMENT_TYPE,
            self::ELEMENT_ID,
        );
    }

    #endregion
}
