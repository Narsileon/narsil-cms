<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Traits\HasElement;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TemplateSectionElement extends Model
{
    use HasElement;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;
        $this->timestamps = false;

        $this->appends = array_merge([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ], $this->appends);

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        $this->touches = [
            self::RELATION_TEMPLATE_SECTION,
        ];

        $this->with = array_merge([
            self::RELATION_ELEMENT,
        ], $this->with);

        parent::__construct($attributes);

        if ($element = Arr::get($attributes, self::RELATION_ELEMENT))
        {
            $this->setRelation(self::RELATION_ELEMENT, $element);
        }
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'template_section_element';

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "template section id" column.
     *
     * @var string
     */
    final public const TEMPLATE_SECTION_ID = 'template_section_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "template section" relation.
     *
     * @var string
     */
    final public const RELATION_TEMPLATE_SECTION = 'template_section';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated template section.
     *
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

    #endregion
}
