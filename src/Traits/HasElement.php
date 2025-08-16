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

    /**
     * @var string The name of the "description" column.
     */
    final public const DESCRIPTION = 'description';
    /**
     * @var string The name of the "element id" column.
     */
    final public const ELEMENT_ID = 'element_id';
    /**
     * @var string The name of the "element type" column.
     */
    final public const ELEMENT_TYPE = 'element_type';
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
     * @var string The name of the "position" column.
     */
    final public const POSITION = 'position';
    /**
     * @var string The name of the "width" column.
     */
    final public const WIDTH = 'width';

    /**
     * @var string The name of the "icon" attribute.
     */
    final public const ATTRIBUTE_ICON = 'icon';

    /**
     * @var string The name of the "element" relation.
     */
    final public const RELATION_ELEMENT = 'element';

    #endregion

    #region RELATIONS

    /**
     * @return MorphTo
     */
    public function element(): MorphTo
    {
        return $this
            ->morphTo(
                self::RELATION_ELEMENT,
                self::ELEMENT_TYPE,
                self::ELEMENT_ID,
            );
    }

    #endregion

    #region ATTRIBUTES

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
}
