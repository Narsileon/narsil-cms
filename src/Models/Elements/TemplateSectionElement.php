<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Narsil\Traits\HasElement;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateSectionElement extends Model
{
    use HasElement;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->timestamps = false;

        $this->touches = [
            self::RELATION_TEMPLATE_SECTION,
        ];

        $this->translatable = [
            self::DESCRIPTION,
            self::NAME,
        ];

        $this->with = [
            self::RELATION_ELEMENT,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ]);

        $this->mergeGuarded([
            self::ID,
        ]);

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
    final public function template_section(): BelongsTo
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
