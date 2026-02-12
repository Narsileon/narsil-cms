<?php

namespace Narsil\Cms\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Narsil\Base\Traits\HasUuidPrimaryKey;
use Narsil\Cms\Casts\JsonCast;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Traits\HasTranslations;
use Narsil\Cms\Traits\IsOrderable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class EntityNode extends Model
{
    use HasTranslations;
    use HasUuidPrimaryKey;
    use IsOrderable;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = static::TABLE;

        $this->timestamps = false;

        $this->translatable = [
            self::ACTIVE,
            self::VALUE,
        ];

        $this->mergeCasts([
            self::VALUE => JsonCast::class,
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
    public const TABLE = 'entity_nodes';

    #region • COLUMNS

    /**
     * The name of the "active" column.
     *
     * @var string
     */
    final public const ACTIVE = 'active';

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
     * The name of the "owner uuid" column.
     *
     * @var string
     */
    final public const OWNER_UUID = 'owner_uuid';

    /**
     * The name of the "parent uuid" column.
     *
     * @var string
     */
    final public const PARENT_UUID = 'parent_uuid';

    /**
     * The name of the "path" column.
     *
     * @var string
     */
    final public const PATH = 'path';

    /**
     * The name of the "template tab element uuid" column.
     *
     * @var string
     */
    final public const TEMPLATE_TAB_ELEMENT_UUID = 'template_tab_element_uuid';

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
     * The name of the "owner" relation.
     *
     * @var string
     */
    final public const RELATION_OWNER = 'owner';

    /**
     * The name of the "parent" relation.
     *
     * @var string
     */
    final public const RELATION_PARENT = 'parent';

    /**
     * The name of the "relations" relation.
     *
     * @var string
     */
    final public const RELATION_RELATIONS = 'relations';

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
                static::class,
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
     * Get the associated owner.
     *
     * @return BelongsTo
     */
    final public function owner(): BelongsTo
    {
        return $this
            ->belongsTo(
                Entity::class,
                self::OWNER_UUID,
                Entity::UUID,
            );
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
     * Get the associated relations.
     *
     * @return HasMany
     */
    final public function relations(): HasMany
    {
        return $this
            ->hasMany(
                static::entityNodeRelationClass(),
                EntityNodeRelation::OWNER_NODE_UUID,
                self::UUID,
            );
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

    #region PROTECTED METHODS

    /**
     * Get the class of the entity.
     *
     * @return string
     */
    protected static function entityClass(): string
    {
        return preg_replace('/Node$/', '', static::class);
    }

    /**
     * Get the class of the entity node relation.
     *
     * @return string
     */
    protected static function entityNodeRelationClass(): string
    {
        return static::class . 'Relation';
    }

    #endregion
}
