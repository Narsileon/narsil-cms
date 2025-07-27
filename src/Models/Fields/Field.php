<?php

namespace Narsil\Models\Fields;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @var string The name of the "icon" column.
     */
    final public const ICON = 'icon';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "index" column.
     */
    final public const INDEX = 'index';
    /**
     * @var string The name of the "name" column.
     */
    final public const NAME = 'name';
    /**
     * @var string The name of the "parent id" column.
     */
    final public const PARENT_ID = 'parent_id';
    /**
     * @var string The name of the "settings" column.
     */
    final public const SETTINGS = 'settings';
    /**
     * @var string The name of the "type" column.
     */
    final public const TYPE = 'type';
    /**
     * @var string The name of the "visibility" column.
     */
    final public const VISIBILITY = 'visibility';
    /**
     * @var string The name of the "width" column.
     */
    final public const WIDTH = 'width';

    /**
     * @var string The name of the "conditions" relation.
     */
    final public const RELATION_CONDITIONS = 'conditions';
    /**
     * @var string The name of the "fields" relation.
     */
    final public const RELATION_FIELDS = 'fields';
    /**
     * @var string The name of the "parent" relation.
     */
    final public const RELATION_PARENT = 'parent';
    /**
     * @var string The name of the "sets" relation.
     */
    final public const RELATION_SETS = 'sets';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'fields';

    #endregion

    #region RELATIONS

    /**
     * @return HasMany
     */
    public function conditions(): HasMany
    {
        return $this
            ->hasMany(
                FieldCondition::class,
                FieldCondition::OWNER_ID,
                self::ID,
            );
    }

    /**
     * @return HasMany
     */
    public function fields(): HasMany
    {
        return $this
            ->hasMany(
                Field::class,
                Field::PARENT_ID,
                self::ID,
            );
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this
            ->belongsTo(
                Field::class,
                self::PARENT_ID,
                Field::ID,
            );
    }

    /**
     * @return BelongsToMany
     */
    public function sets(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Field::class,
                FieldSet::TABLE,
                FieldSet::FIELD_ID,
                FieldSet::SET_ID,
            );
    }

    #endregion
}
