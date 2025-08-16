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
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateSection extends Model
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
     * @var string The name of the "template id" column.
     */
    final public const TEMPLATE_ID = 'template_id';
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
     * @var string The name of the "blocks" relation.
     */
    final public const RELATION_BlOCKS = 'blocks';
    /**
     * @var string The name of the "elements" relation.
     */
    final public const RELATION_ELEMENTS = 'elements';
    /**
     * @var string The name of the "fields" relation.
     */
    final public const RELATION_FIELDS = 'fields';
    /**
     * @var string The name of the "template" relation.
     */
    final public const RELATION_TEMPLATE = 'template';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'template_sections';

    #endregion

    #region RELATIONS

    /**
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
