<?php

namespace Narsil\Models\Fields;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
     * @var string The name of the "fields" relation.
     */
    final public const RELATION_FIELDS = 'fields';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'field_sets';

    #endregion

    #region RELATIONS

    /**
     * @return HasManyThrough
     */
    final public function fields(): HasManyThrough
    {
        return $this->hasManyThrough(
            Field::class,
            FieldSetField::class,
            FieldSetField::FIELD_SET_ID,
            Field::ID,
            self::ID,
            FieldSetField::FIELD_ID
        );
    }

    #endregion
}
