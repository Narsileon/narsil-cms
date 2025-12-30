<?php

namespace Narsil\Models\Structures;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateSection extends Model
{
    use HasTranslations;
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;

        $this->touches = [
            self::RELATION_TEMPLATE,
        ];

        $this->translatable = [
            self::NAME,
        ];

        $this->with = [
            self::RELATION_ELEMENTS,
        ];

        $this->mergeGuarded([
            self::UUID,
        ]);

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

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

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

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated blocks.
     *
     * @return MorphToMany
     */
    final public function blocks(): MorphToMany
    {
        return $this
            ->morphedByMany(
                Block::class,
                TemplateSectionElement::RELATION_ELEMENT,
                TemplateSectionElement::TABLE,
                TemplateSectionElement::OWNER_UUID,
                TemplateSectionElement::ELEMENT_ID,
            )
            ->using(TemplateSectionElement::class);
    }

    /**
     * Get the associated elements.
     *
     * @return HasMany
     */
    final public function elements(): HasMany
    {
        return $this
            ->hasMany(
                TemplateSectionElement::class,
                TemplateSectionElement::OWNER_UUID,
                self::UUID,
            )
            ->orderBy(TemplateSectionElement::POSITION);
    }

    /**
     * Get the associated fields.
     *
     * @return MorphToMany
     */
    final public function fields(): MorphToMany
    {
        return $this
            ->morphedByMany(
                Field::class,
                TemplateSectionElement::RELATION_ELEMENT,
                TemplateSectionElement::TABLE,
                TemplateSectionElement::OWNER_UUID,
                TemplateSectionElement::ELEMENT_ID,
            )
            ->using(TemplateSectionElement::class);
    }

    /**
     * Get the associated template.
     *
     * @return BelongsTo
     */
    final public function template(): BelongsTo
    {
        return $this
            ->belongsTo(
                Template::class,
                self::TEMPLATE_ID,
                Template::ID,
            );
    }

    #endregion

    #endregion
}
