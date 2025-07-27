<?php

namespace Narsil\Models\Fields;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Narsil\Models\Fields\Field;
use Narsil\Models\Fields\FieldSetItem;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldSet extends Model
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
     * @var string The name of the "field sets" count.
     */
    final public const COUNT_FIELD_SETS = 'field_sets_count';
    /**
     * @var string The name of the "fields" count.
     */
    final public const COUNT_FIELDS = 'fields_count';

    /**
     * @var string The name of the "field sets" relation.
     */
    final public const RELATION_FIELD_SETS = 'field_sets';
    /**
     * @var string The name of the "fields" relation.
     */
    final public const RELATION_FIELDS = 'fields';
    /**
     * @var string The name of the "items" relation.
     */
    final public const RELATION_ITEMS = 'items';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'field_sets';

    #endregion

    #region RELATIONS

    public function fields(): MorphToMany
    {
        return $this->morphedByMany(
            Field::class,
            FieldSetItem::RELATION_ITEM,
            FieldSetItem::TABLE,
            FieldSetItem::FIELD_SET_ID,
            FieldSetItem::ITEM_ID,
        );
    }

    public function field_sets(): MorphToMany
    {
        return $this->morphedByMany(
            FieldSet::class,
            FieldSetItem::RELATION_ITEM,
            FieldSetItem::TABLE,
            FieldSetItem::FIELD_SET_ID,
            FieldSetItem::ITEM_ID,
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            FieldSetItem::class,
            FieldSetItem::FIELD_SET_ID,
            self::ID,
        );
    }

    #endregion
}
