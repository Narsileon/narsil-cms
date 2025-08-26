<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\TemplateSectionElement;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TemplateSection extends Model
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        $this->touches = [
            self::RELATION_TEMPLATE,
        ];

        $this->with = array_merge([
            self::RELATION_ELEMENTS,
        ], $this->with);

        parent::__construct($attributes);

        if ($elements = Arr::get($attributes, self::RELATION_ELEMENTS))
        {
            $this->setRelation(self::RELATION_ELEMENTS, collect($elements));
        }
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'template_sections';

    #region • COLUMNS

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
     * The name of the "template id" column.
     *
     * @var string
     */
    final public const TEMPLATE_ID = 'template_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "blocks" relation.
     *
     * @var string
     */
    final public const RELATION_BlOCKS = 'blocks';

    /**
     * The name of the "elements" relation.
     *
     * @var string
     */
    final public const RELATION_ELEMENTS = 'elements';

    /**
     * The name of the "fields" relation.
     *
     * @var string
     */
    final public const RELATION_FIELDS = 'fields';

    /**
     * The name of the "template" relation.
     *
     * @var string
     */
    final public const RELATION_TEMPLATE = 'template';

    #endregion

    #endregion

    #region RELATIONSHIPS

    /**
     * Get the associated blocks.
     *
     * @return MorphToMany
     */
    public function blocks(): MorphToMany
    {
        return $this
            ->morphedByMany(
                Block::class,
                TemplateSectionElement::RELATION_ELEMENT,
                TemplateSectionElement::TABLE,
                TemplateSectionElement::TEMPLATE_SECTION_ID,
                TemplateSectionElement::ELEMENT_ID,
            );
    }

    /**
     * Get the associated elements.
     *
     * @return HasMany
     */
    public function elements(): HasMany
    {
        return $this
            ->hasMany(
                TemplateSectionElement::class,
                TemplateSectionElement::TEMPLATE_SECTION_ID,
                self::ID,
            )
            ->orderBy(TemplateSectionElement::POSITION);
    }

    /**
     * Get the associated fields.
     *
     * @return MorphToMany
     */
    public function fields(): MorphToMany
    {
        return $this
            ->morphedByMany(
                Field::class,
                TemplateSectionElement::RELATION_ELEMENT,
                TemplateSectionElement::TABLE,
                TemplateSectionElement::TEMPLATE_SECTION_ID,
                TemplateSectionElement::ELEMENT_ID,
            );
    }

    /**
     * Get the associated template.
     *
     * @return BelongsTo
     */
    public function template(): BelongsTo
    {
        return $this
            ->belongsTo(
                Template::class,
                self::TEMPLATE_ID,
                Template::ID,
            );
    }

    #endregion
}
