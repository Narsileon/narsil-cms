<?php

namespace Narsil\Cms\Models\Collections;

#region USE

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Narsil\Cms\Database\Factories\BlockFactory;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[UseFactory(BlockFactory::class)]
class Block extends BaseElement
{
    use HasFactory;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->translatable = [
            self::DESCRIPTION,
            self::LABEL,
        ];

        $this->with = [
            self::RELATION_ELEMENTS,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ]);

        $this->mergeGuarded([
            self::ID,
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
    final public const TABLE = 'blocks';

    #region • COLUMNS

    /**
     * The name of the "collapsible" column.
     *
     * @var string
     */
    final public const COLLAPSIBLE = 'collapsible';

    /**
     * The name of the "virtual" column.
     *
     * @var string
     */
    final public const VIRTUAL = 'virtual';

    #endregion

    #region • COUNTS

    /**
     * The name of the "blocks" count.
     *
     * @var string
     */
    final public const COUNT_BLOCKS = 'blocks_count';

    /**
     * The name of the "elements" count.
     *
     * @var string
     */
    final public const COUNT_ELEMENTS = 'elements_count';

    /**
     * The name of the "fields" count.
     *
     * @var string
     */
    final public const COUNT_FIELDS = 'fields_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "blocks" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCKS = 'blocks';

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
                BlockElement::RELATION_BASE,
                BlockElement::TABLE,
                BlockElement::OWNER_ID,
                BlockElement::BASE_ID,
            )
            ->using(BlockElement::class);
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
                BlockElement::class,
                BlockElement::OWNER_ID,
                self::ID,
            )
            ->orderBy(BlockElement::POSITION);
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
                BlockElement::RELATION_BASE,
                BlockElement::TABLE,
                BlockElement::OWNER_ID,
                BlockElement::BASE_ID,
            )
            ->using(BlockElement::class);
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    #region • ACCESSORS

    /**
     * Get the "icon" attribute.
     *
     * @return string
     */
    protected function icon(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return 'block';
            },
        );
    }

    #endregion

    #endregion
}
