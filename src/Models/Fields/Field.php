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
     * @var string The name of the "type" column.
     */
    final public const TYPE = 'type';

    /**
     * @var string The name of the "field sets" relation.
     */
    final public const RELATION_FIELD_SETS = 'field_sets';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'fields';

    #endregion

    #region RELATIONS

    /**
     * @return HasManyThrough
     */
    final public function field_sets(): HasManyThrough
    {
        return $this->hasManyThrough(
            FieldSet::class,
            FieldSetField::class,
            FieldSetField::FIELD_ID,
            FieldSet::ID,
            self::ID,
            FieldSetField::FIELD_SET_ID
        );
    }

    #endregion
}
