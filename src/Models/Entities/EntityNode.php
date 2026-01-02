<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Narsil\Casts\JsonCast;
use Narsil\Models\Forms\Form;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityNode extends Model
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
        $this->timestamps = false;

        $this->translatable = [
            self::VALUE,
        ];

        $this->mergeCasts([
            self::VALUE => JsonCast::class,
        ]);

        $this->mergeGuarded([
            self::UUID,
        ]);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'entity_nodes';

    #region • COLUMNS

    /**
     * The name of the "block id" column.
     *
     * @var string
     */
    final public const BLOCK_ID = 'block_id';

    /**
     * The name of the "block element uuid" column.
     *
     * @var string
     */
    final public const BLOCK_ELEMENT_UUID = 'block_element_uuid';

    /**
     * The name of the "element id" column.
     *
     * @var string
     */
    final public const ELEMENT_ID = 'element_id';

    /**
     * The name of the "element type" column.
     *
     * @var string
     */
    final public const ELEMENT_TYPE = 'element_type';

    /**
     * The name of the "entity uuid" column.
     *
     * @var string
     */
    final public const ENTITY_UUID = 'entity_uuid';

    /**
     * The name of the "parent uuid" column.
     *
     * @var string
     */
    final public const PARENT_UUID = 'parent_uuid';

    /**
     * The name of the "position" column.
     *
     * @var string
     */
    final public const POSITION = 'position';

    /**
     * The name of the "template tab element uuid" column.
     *
     * @var string
     */
    final public const TEMPLATE_TAB_ELEMENT_UUID = 'template_tab_element_uuid';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    /**
     * The name of the "value" column.
     *
     * @var string
     */
    final public const VALUE = 'value';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "block" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCK = 'block';

    /**
     * The name of the "block element" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCK_ELEMENT = 'block_element';

    /**
     * The name of the "children" relation.
     *
     * @var string
     */
    final public const RELATION_CHILDREN = 'children';

    /**
     * The name of the "element" relation.
     *
     * @var string
     */
    final public const RELATION_ELEMENT = 'element';

    /**
     * The name of the "entities" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITIES = 'entities';

    /**
     * The name of the "entity" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY = 'entity';

    /**
     * The name of the "forms" relation.
     *
     * @var string
     */
    final public const RELATION_FORMS = 'forms';

    /**
     * The name of the "parent" relation.
     *
     * @var string
     */
    final public const RELATION_PARENT = 'parent';

    /**
     * The name of the "site pages" relation.
     *
     * @var string
     */
    final public const RELATION_SITE_PAGES = 'site_pages';

    /**
     * The name of the "template tab element" relation.
     *
     * @var string
     */
    final public const RELATION_TEMPLATE_TAB_ELEMENT = 'template_tab_element';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated block.
     *
     * @return BelongsTo
     */
    final public function block(): BelongsTo
    {
        return $this
            ->belongsTo(
                Block::class,
                self::BLOCK_ID,
                Block::ID,
            );
    }

    /**
     * Get the associated block element.
     *
     * @return BelongsTo
     */
    final public function block_element(): BelongsTo
    {
        return $this
            ->belongsTo(
                BlockElement::class,
                self::BLOCK_ELEMENT_UUID,
                BlockElement::UUID,
            );
    }

    /**
     * Get the associated children.
     *
     * @return HasMany
     */
    final public function children(): HasMany
    {
        return $this
            ->hasMany(
                EntityNode::class,
                EntityNode::PARENT_UUID,
                self::UUID,
            );
    }

    /**
     * Get the associated element.
     *
     * @return MorphTo
     */
    final public function element(): MorphTo
    {
        return $this
            ->morphTo(
                self::RELATION_ELEMENT,
                self::ELEMENT_TYPE,
                self::ELEMENT_ID,
            );
    }

    /**
     * Get the associated entity.
     *
     * @return BelongsTo
     */
    final public function entity(): BelongsTo
    {
        return $this
            ->belongsTo(
                Entity::class,
                self::ENTITY_UUID,
                Entity::UUID,
            );
    }

    /**
     * Get the associated entities.
     *
     * @return BelongsToMany
     */
    final public function entities(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Entity::class,
                EntityNodeEntity::TABLE,
                EntityNodeEntity::ENTITY_NODE_UUID,
                EntityNodeEntity::ENTITY_UUID,
            )
            ->using(EntityNodeEntity::class);
    }

    /**
     * Get the associated forms.
     *
     * @return BelongsToMany
     */
    final public function forms(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Form::class,
                EntityNodeForm::TABLE,
                EntityNodeForm::ENTITY_NODE_UUID,
                EntityNodeForm::FORM_ID,
            )
            ->using(EntityNodeForm::class);
    }

    /**
     * Get the associated parent.
     *
     * @return BelongsTo
     */
    final public function parent(): BelongsTo
    {
        return $this
            ->belongsTo(
                EntityNode::class,
                self::PARENT_UUID,
                EntityNode::UUID,
            );
    }

    /**
     * Get the associated site pages.
     *
     * @return BelongsToMany
     */
    final public function site_pages(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                SitePage::class,
                EntityNodeSitePage::TABLE,
                EntityNodeSitePage::ENTITY_NODE_UUID,
                EntityNodeSitePage::SITE_PAGE_ID,
            )
            ->using(EntityNodeSitePage::class);
    }

    /**
     * Get the associated template tab element.
     *
     * @return BelongsTo
     */
    final public function template_tab_element(): BelongsTo
    {
        return $this
            ->belongsTo(
                TemplateTabElement::class,
                self::TEMPLATE_TAB_ELEMENT_UUID,
                TemplateTabElement::UUID,
            );
    }

    #endregion

    #endregion
}
