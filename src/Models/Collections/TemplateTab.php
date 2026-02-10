<?php

namespace Narsil\Cms\Models\Collections;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Narsil\Cms\Traits\HasTranslations;
use Narsil\Base\Traits\HasUuidKey;
use Narsil\Cms\Traits\IsOrderable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateTab extends Model
{
    use HasTranslations;
    use HasUuidKey;
    use IsOrderable;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->touches = [
            self::RELATION_TEMPLATE,
        ];

        $this->translatable = [
            self::LABEL,
        ];

        $this->with = [
            self::RELATION_ELEMENTS,
        ];

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'template_tabs';

    #region • COLUMNS

    /**
     * The name of the "handle" column.
     *
     * @var string
     */
    final public const HANDLE = 'handle';

    /**
     * The name of the "label" column.
     *
     * @var string
     */
    final public const LABEL = 'label';

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
                TemplateTabElement::RELATION_BASE,
                TemplateTabElement::TABLE,
                TemplateTabElement::OWNER_UUID,
                TemplateTabElement::BASE_ID,
            )
            ->using(TemplateTabElement::class);
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
                TemplateTabElement::class,
                TemplateTabElement::OWNER_UUID,
                self::UUID,
            )
            ->orderBy(TemplateTabElement::POSITION);
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
                TemplateTabElement::RELATION_BASE,
                TemplateTabElement::TABLE,
                TemplateTabElement::OWNER_UUID,
                TemplateTabElement::BASE_ID,
            )
            ->using(TemplateTabElement::class);
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
