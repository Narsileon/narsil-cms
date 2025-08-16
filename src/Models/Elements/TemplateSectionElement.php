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
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateSectionElement extends Model
{
    use HasElement;

    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
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
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "template section id" column.
     */
    final public const TEMPLATE_SECTION_ID = 'template_section_id';

    /**
     * @var string The name of the "template section" relation.
     */
    final public const RELATION_TEMPLATE_SECTION = 'template_section';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'template_section_element';

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

    #endregion
}
