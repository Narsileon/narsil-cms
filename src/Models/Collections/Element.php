<?php

namespace Narsil\Models\Collections;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Narsil\Traits\HasIdentifier;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class Element extends MorphPivot
{
    use HasIdentifier;
    use HasTranslations;
    use HasUuids;

    #region CONSTANTS

    #region • COLUMNS

    /**
     * The name of the "base id" column.
     *
     * @var string
     */
    final public const BASE_ID = 'base_id';

    /**
     * The name of the "base type" column.
     *
     * @var string
     */
    final public const BASE_TYPE = 'base_type';

    /**
     * The name of the "class name" column.
     *
     * @var string
     */
    final public const CLASS_NAME = 'class_name';

    /**
     * The name of the "description" column.
     *
     * @var string
     */
    final public const DESCRIPTION = 'description';

    /**
     * The name of the "handle" column.
     *
     * @var string
     */
    final public const HANDLE = 'handle';

    /**
     * The name of the "label" column.
     *
     * @var string
     */
    final public const LABEL = 'label';

    /**
     * The name of the "position" column.
     *
     * @var string
     */
    final public const POSITION = 'position';

    /**
     * The name of the "required" column.
     *
     * @var string
     */
    final public const REQUIRED = 'required';

    /**
     * The name of the "translatable" column.
     *
     * @var string
     */
    final public const TRANSLATABLE = 'translatable';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    /**
     * The name of the "width" column.
     *
     * @var string
     */
    final public const WIDTH = 'width';

    #endregion

    #region • ATTRIBUTES

    /**
     * The name of the "icon" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_ICON = 'icon';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "base" relation.
     *
     * @var string
     */
    final public const RELATION_BASE = 'base';

    /**
     * The name of the "conditions" relation.
     *
     * @var string
     */
    final public const RELATION_CONDITIONS = 'conditions';

    /**
     * The name of the "conditions" relation.
     *
     * @var string
     */
    final public const RELATION_OWNER = 'owner';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated base.
     *
     * @return MorphTo
     */
    final public function base(): MorphTo
    {
        return $this->morphTo(
            self::RELATION_BASE,
            self::BASE_TYPE,
            self::BASE_ID,
        );
    }

    /**
     * Get the associated conditions.
     *
     * @return HasMany
     */
    abstract public function conditions(): HasMany;

    /**
     * Get the associated owner.
     *
     * @return BelongsTo
     */
    abstract public function owner(): BelongsTo;

    #endregion

    #endregion

    #region PROTECTED METHODS

    #region • ACCESSORS

    /**
     * Get the "icon" attribute.
     *
     * @return string
     */
    final protected function icon(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return $this->{self::RELATION_BASE}->{self::ATTRIBUTE_ICON} ?? null;
            },
        );
    }

    /**
     * Get the "identifier" attribute.
     *
     * @return string
     */
    final protected function identifier(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                $base = $this->{self::RELATION_BASE};

                $key = $base->getKey();
                $table = $base->getTable();

                return !empty($key) ? "$table-$key" : $table;
            },
        );
    }

    #endregion

    #endregion
}
