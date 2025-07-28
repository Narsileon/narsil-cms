<?php

namespace Narsil\Models\Templates;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\Templates\TemplateSection;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateSectionElement extends Pivot
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
     * @var string The name of the "template section id" column.
     */
    final public const TEMPLATE_SECTION_ID = 'template_section_id';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "element id" column.
     */
    final public const ELEMENT_ID = 'item_id';
    /**
     * @var string The name of the "element type" column.
     */
    final public const ELEMENT_TYPE = 'item_type';
    /**
     * @var string The name of the "position" column.
     */
    final public const POSITION = 'position';

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
    final public const TABLE = 'field_set_item';

    #endregion

    #region RELATIONS

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

    /**
     * @return MorphTo
     */
    public function element(): MorphTo
    {
        return $this->morphTo(
            self::RELATION_ELEMENT,
            self::ELEMENT_TYPE,
            self::ELEMENT_ID,
        );
    }

    #endregion
}
