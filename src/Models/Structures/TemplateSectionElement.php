<?php

namespace Narsil\Models\Structures;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Support\Arr;
use Narsil\Traits\HasElement;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateSectionElement extends MorphPivot
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

        $this->primaryKey = self::UUID;
        $this->timestamps = false;

        $this->touches = [
            self::RELATION_TEMPLATE_SECTION,
        ];

        $this->translatable = [
            self::DESCRIPTION,
            self::NAME,
        ];

        $this->with = [
            self::RELATION_CONDITIONS,
            self::RELATION_ELEMENT,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ]);

        $this->mergeGuarded([
            self::UUID,
        ]);

        parent::__construct($attributes);

        if ($conditions = Arr::get($attributes, self::RELATION_CONDITIONS))
        {
            $this->setRelation(self::RELATION_CONDITIONS, collect($conditions));
        }

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
     * The name of the "template section uuid" column.
     *
     * @var string
     */
    final public const TEMPLATE_SECTION_UUID = 'template_section_uuid';

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
                self::TEMPLATE_SECTION_UUID,
                TemplateSection::UUID,
            );
    }

    #endregion

    #endregion
}
