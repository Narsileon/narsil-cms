<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Traits\HasIdentifier;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait HasElement
{
    use HasIdentifier;

    #region CONSTANTS

    #region • COLUMNS

    /**
     * The name of the "description" column.
     *
     * @var string
     */
    final public const DESCRIPTION = 'description';

    /**
     * The name of the "element id" column.
     *
     * @var string
     */
    final public const ELEMENT_ID = 'element_id';

    /**
     * The name of the "element type" column.
     *
     * @var string
     */
    final public const ELEMENT_TYPE = 'element_type';

    /**
     * The name of the "handle" column.
     *
     * @var string
     */
    final public const HANDLE = 'handle';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "name" column.
     *
     * @var string
     */
    final public const NAME = 'name';

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
     * The name of the "element" relation.
     *
     * @var string
     */
    final public const RELATION_ELEMENT = 'element';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • ACCESSORS

    /**
     * @return string|null
     */
    public function getIconAttribute(): ?string
    {
        return match ($this->{self::ELEMENT_TYPE})
        {
            Block::class => $this->{self::RELATION_ELEMENT}->{Block::ATTRIBUTE_ICON},
            Field::class => $this->{self::RELATION_ELEMENT}->{Field::ATTRIBUTE_ICON},
            default => null
        };
    }

    /**
     * @return string
     */
    public function getIdentifierAttribute(): string
    {
        $element = $this->{self::RELATION_ELEMENT};

        $key = $element->getKey();
        $table = $element->getTable();

        return !empty($key) ? "$table-$key" : $table;
    }

    #endregion

    #region • RELATIONSHIPS

    /**
     * Get the associated element.
     *
     * @return MorphTo
     */
    final public function element(): MorphTo
    {
        return $this
            ->morphTo(
                self::RELATION_ELEMENT,
                self::ELEMENT_TYPE,
                self::ELEMENT_ID,
            );
    }

    #endregion

    #endregion
}
