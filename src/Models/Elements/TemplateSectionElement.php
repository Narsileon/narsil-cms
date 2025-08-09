<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Traits\HasIdentifier;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateSectionElement extends Model
{
    use HasIdentifier;

    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->appends = array_merge([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ], $this->appends);

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
     * @var string The name of the "element id" column.
     */
    final public const ELEMENT_ID = 'element_id';
    /**
     * @var string The name of the "element type" column.
     */
    final public const ELEMENT_TYPE = 'element_type';
    /**
     * @var string The name of the "name" column.
     */
    final public const NAME = 'name';
    /**
     * @var string The name of the "position" column.
     */
    final public const POSITION = 'position';
    /**
     * @var string The name of the "template section id" column.
     */
    final public const TEMPLATE_SECTION_ID = 'template_section_id';
    /**
     * @var string The name of the "width" column.
     */
    final public const WIDTH = 'width';

    /**
     * @var string The name of the "icon" attribute.
     */
    final public const ATTRIBUTE_ICON = 'icon';

    /**
     * @var string The name of the "template section" relation.
     */
    final public const RELATION_TEMPLATE_SECTION = 'template_section';
    /**
     * @var string The name of the "element" relation.
     */
    final public const RELATION_ELEMENT = 'element';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'template_section_element';

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

    /**
     * @return BelongsTo
     */
    public function template_section(): BelongsTo
    {
        return $this
            ->belongsTo(
                TemplateSection::class,
                self::TEMPLATE_SECTION_ID,
                TemplateSection::ID,
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
