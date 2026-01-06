<?php

namespace Narsil\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface IHasElement
{
    #region CONSTANTS

    #region • COLUMNS

    /**
     * The name of the "description" column.
     *
     * @var string
     */
    public const DESCRIPTION = 'description';

    /**
     * The name of the "element id" column.
     *
     * @var string
     */
    public const ELEMENT_ID = 'element_id';

    /**
     * The name of the "element type" column.
     *
     * @var string
     */
    public const ELEMENT_TYPE = 'element_type';

    /**
     * The name of the "handle" column.
     *
     * @var string
     */
    public const HANDLE = 'handle';

    /**
     * The name of the "label" column.
     *
     * @var string
     */
    public const LABEL = 'label';

    /**
     * The name of the "position" column.
     *
     * @var string
     */
    public const POSITION = 'position';

    /**
     * The name of the "required" column.
     *
     * @var string
     */
    public const REQUIRED = 'required';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    public const UUID = 'uuid';

    /**
     * The name of the "width" column.
     *
     * @var string
     */
    public const WIDTH = 'width';

    #endregion

    #region • ATTRIBUTES

    /**
     * The name of the "icon" attribute.
     *
     * @var string
     */
    public const ATTRIBUTE_ICON = 'icon';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "conditions" relation.
     *
     * @var string
     */
    public const RELATION_CONDITIONS = 'conditions';

    /**
     * The name of the "element" relation.
     *
     * @var string
     */
    public const RELATION_ELEMENT = 'element';

    /**
     * The name of the "conditions" relation.
     *
     * @var string
     */
    public const RELATION_OWNER = 'owner';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONS

    /**
     * Get the associated conditions.
     *
     * @return HasMany
     */
    public function conditions(): HasMany;

    /**
     * Get the associated owner.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo;

    #endregion

    #endregion
}
